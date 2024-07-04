import { ref } from 'vue';

export const isAuthenticated = ref(localStorage.getItem('userEmail') ? true : false);