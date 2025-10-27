/**
 * API通信用のクラス
 * PHPバックエンドとの通信を担当
 */
class WorkoutAPI {
    constructor(baseUrl = 'api.php') {
        this.baseUrl = baseUrl;
    }

    async request(action, data = {}) {
        const response = await fetch(this.baseUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ action, ...data }),
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const result = await response.json();
        if (!result.success) {
            throw new Error(result.error || 'Unknown error');
        }

        return result.data;
    }

    async createSession(memo = null) {
        return await this.request('createSession', { memo });
    }

    async addExercise(sessionId, exerciseName, memo = null) {
        return await this.request('addExercise', { sessionId, exerciseName, memo });
    }

    async recordSet(sessionId, exerciseId, weight, reps, memo = null) {
        return await this.request('recordSet', { sessionId, exerciseId, weight, reps, memo });
    }

    async getHistory(limit = 30) {
        return await this.request('getHistory', { limit });
    }

    async finishSession(sessionId) {
        return await this.request('finishSession', { sessionId });
    }
}

