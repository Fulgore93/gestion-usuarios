<template>
    <div class="login">
        <div class="col-md-6 offset-md-3">
            <form @submit.prevent="login">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" v-model="email" required class="form-control">
                    <p v-if="errors.email" class="alert alert-danger" role="alert">{{ errors.email.join(', ') }}</p>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" v-model="password" required class="form-control">
                    <p v-if="errors.password" class="alert alert-danger" role="alert">{{ errors.password.join(', ') }}</p>
                </div>
                <br>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary float-end">Log in</button>
                </div>
            </form>
            <router-link to="/register">Registrar usuario</router-link>
        </div>
    </div>
</template>

<script>
import { ref } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';
import { isAuthenticated } from '../../events/eventLogin';

export default {
    setup() {
        const email = ref('');
        const password = ref('');
        const router = useRouter();
        const errors = ref({});

        const login = async () => {
            try {
                const response = await axios.post('/api/v1/login', {
                    email: email.value,
                    password: password.value,
                });
                localStorage.setItem('userEmail', email.value);
                localStorage.setItem('token', response.data.data);
                isAuthenticated.value = true;
                Swal.fire({
                    position: "top-end",
                    toast: true,
                    icon: "success",
                    title: response.data.user_message,
                    showConfirmButton: false,
                    timer: 2000
                });
                router.push('/users');
            } catch (error) {
                if (error.response && error.response.data && error.response.data.data) {
                    errors.value = error.response.data.data || {}
                    Swal.fire({
                        position: "top-end",
                        toast: true,
                        icon: "error",
                        title: error.response.data.user_message,
                        showConfirmButton: false,
                        timer: 2000
                    });
                } else {
                    Swal.fire({
                        position: "top-end",
                        toast: true,
                        icon: "error",
                        title: 'Ha ocurrido un error inesperado, inténtelo nuevamente.',
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            }
        };

        return { email, password, errors, login };
    },
};
</script>