import axios from 'axios'

// axios conf
const apiClient = axios.create({
    baseURL: '/api/v1',
    headers: {
        'Content-Type': 'application/json',
    },
});

export const getUsers = (token) => {
    return apiClient.get('/users', {
        headers: {
            Authorization: `Bearer ${token}`,
        },
    });
};

export const getUser = (token, userId) => {
    return apiClient.get(`/users/${userId}`, {
        headers: {
            Authorization: `Bearer ${token}`,
        },
    });
};

export const registerUser = async (user) => {
    return apiClient.post('/register', user);
};

export const createUser = async (token, user) => {
    return apiClient.post('/users', user, {
        headers: {
            Authorization: `Bearer ${token}`,
        },
    });
};

export const editUser = (token, userId, user) => {
    return apiClient.put(`/users/${userId}`, user, {
        headers: {
            Authorization: `Bearer ${token}`,
        },
    });
};

export const deleteUser = async (token, userId) => {
    return apiClient.delete(`/users/${userId}`, {
        headers: {
            Authorization: `Bearer ${token}`,
        },
    });
};