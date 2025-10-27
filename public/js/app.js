/**
 * WorkoutTrackerアプリケーションメインロジック
 */
class WorkoutTrackerApp {
    constructor() {
        this.api = new WorkoutAPI();
        this.currentSession = null;
        this.init();
    }

    async init() {
        this.setupEventListeners();
        await this.loadHistory();
    }

    setupEventListeners() {
        document.getElementById('startSessionBtn').addEventListener('click', () => this.startSession());
        document.getElementById('addExerciseBtn').addEventListener('click', () => this.addExercise());
        document.getElementById('finishSessionBtn').addEventListener('click', () => this.finishSession());

        document.getElementById('exerciseName').addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                this.addExercise();
            }
        });
    }

    async startSession() {
        try {
            const result = await this.api.createSession();
            // APIレスポンスのsessionプロパティを取得
            this.currentSession = result.session;
            this.showActiveSession();
            this.updateSessionDisplay();
        } catch (error) {
            alert('セッション開始に失敗しました: ' + error.message);
        }
    }

    async addExercise() {
        const nameInput = document.getElementById('exerciseName');
        const name = nameInput.value.trim();

        if (!name) {
            alert('種目名を入力してください');
            return;
        }

        try {
            const result = await this.api.addExercise(this.currentSession.id, name);
            // APIレスポンスのsessionプロパティを取得
            this.currentSession = result.session;
            this.updateSessionDisplay();
            nameInput.value = '';
        } catch (error) {
            alert('種目追加に失敗しました: ' + error.message);
        }
    }

    async recordSet(exerciseId, weight, reps) {
        try {
            const result = await this.api.recordSet(
                this.currentSession.id,
                exerciseId,
                parseFloat(weight),
                parseInt(reps)
            );
            // APIレスポンスのsessionプロパティを取得
            this.currentSession = result.session;
            this.updateSessionDisplay();
        } catch (error) {
            alert('セット記録に失敗しました: ' + error.message);
        }
    }

    async finishSession() {
        if (!confirm('セッションを終了しますか？')) {
            return;
        }

        try {
            await this.api.finishSession(this.currentSession.id);
            this.currentSession = null;
            this.showNoSession();
            await this.loadHistory();
            alert('お疲れ様、Bro！セッションが完了した🔥');
        } catch (error) {
            alert('セッション終了に失敗しました: ' + error.message);
        }
    }

    showActiveSession() {
        document.getElementById('noSessionArea').style.display = 'none';
        document.getElementById('activeSessionArea').style.display = 'block';
    }

    showNoSession() {
        document.getElementById('noSessionArea').style.display = 'block';
        document.getElementById('activeSessionArea').style.display = 'none';
    }

    updateSessionDisplay() {
        if (!this.currentSession) return;

        document.getElementById('sessionStartTime').textContent = 
            new Date(this.currentSession.startedAt).toLocaleString('ja-JP');
        document.getElementById('exerciseCount').textContent = this.currentSession.exerciseCount;
        document.getElementById('totalSets').textContent = this.currentSession.totalSetCount;
        document.getElementById('totalVolume').textContent = Math.round(this.currentSession.totalVolume);

        const exercisesList = document.getElementById('exercisesList');
        exercisesList.innerHTML = '';

        this.currentSession.exercises.forEach(exercise => {
            exercisesList.appendChild(this.createExerciseCard(exercise));
        });
    }

    createExerciseCard(exercise) {
        const card = document.createElement('div');
        card.className = 'exercise-card';

        const header = document.createElement('div');
        header.className = 'exercise-header';

        const name = document.createElement('div');
        name.className = 'exercise-name';
        name.textContent = exercise.name;

        const stats = document.createElement('div');
        stats.className = 'exercise-stats';
        stats.textContent = `${exercise.setCount}セット | ${Math.round(exercise.totalVolume)}kg`;

        header.appendChild(name);
        header.appendChild(stats);
        card.appendChild(header);

        const addSetForm = document.createElement('div');
        addSetForm.className = 'add-set-form';
        addSetForm.innerHTML = `
            <input type="number" class="weight-input" placeholder="重量(kg)" step="0.5" min="0">
            <input type="number" class="reps-input" placeholder="回数" step="1" min="0">
            <button class="add-set-btn">セット追加</button>
        `;

        const addButton = addSetForm.querySelector('.add-set-btn');
        const weightInput = addSetForm.querySelector('.weight-input');
        const repsInput = addSetForm.querySelector('.reps-input');

        addButton.addEventListener('click', async () => {
            const weight = weightInput.value;
            const reps = repsInput.value;

            if (!weight || !reps) {
                alert('重量と回数を入力してください');
                return;
            }

            await this.recordSet(exercise.id, weight, reps);
            weightInput.value = '';
            repsInput.value = '';
        });

        card.appendChild(addSetForm);

        if (exercise.sets.length > 0) {
            const setsList = document.createElement('div');
            setsList.className = 'sets-list';

            exercise.sets.forEach((set, index) => {
                const setItem = document.createElement('div');
                setItem.className = 'set-item';
                setItem.innerHTML = `
                    <span class="set-number">SET ${index + 1}</span>
                    <div class="set-details">
                        <span class="set-value">${set.weight}kg</span>
                        <span class="set-value">${set.reps}回</span>
                        <span class="set-value">Volume: ${Math.round(set.volume)}kg</span>
                    </div>
                `;
                setsList.appendChild(setItem);
            });

            card.appendChild(setsList);
        }

        return card;
    }

    async loadHistory() {
        try {
            const result = await this.api.getHistory(30);
            // APIレスポンスのsessionsプロパティを取得
            this.renderHistory(result.sessions || []);
        } catch (error) {
            console.error('履歴読み込みエラー:', error);
            this.renderHistory([]);
        }
    }

    renderHistory(sessions) {
        const historyList = document.getElementById('historyList');
        historyList.innerHTML = '';

        if (!sessions || sessions.length === 0) {
            historyList.innerHTML = '<div class="empty-message">まだトレーニング履歴がありません</div>';
            return;
        }

        sessions.forEach(session => {
            const item = document.createElement('div');
            item.className = 'history-item';

            const header = document.createElement('div');
            header.className = 'history-header';

            const date = document.createElement('div');
            date.className = 'history-date';
            date.textContent = new Date(session.startedAt).toLocaleDateString('ja-JP');

            const stats = document.createElement('div');
            stats.className = 'history-stats';
            stats.textContent = `${session.exerciseCount}種目 | ${session.totalSetCount}セット | ${Math.round(session.totalVolume)}kg`;

            header.appendChild(date);
            header.appendChild(stats);
            item.appendChild(header);

            if (session.exercises.length > 0) {
                const exercises = document.createElement('div');
                exercises.className = 'history-exercises';
                exercises.textContent = '種目: ' + session.exercises.map(ex => ex.name).join(', ');
                item.appendChild(exercises);
            }

            historyList.appendChild(item);
        });
    }
}

document.addEventListener('DOMContentLoaded', () => {
    new WorkoutTrackerApp();
});

