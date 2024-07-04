<template>
    <div class="card">
        <div class="card-header">
            <h4>Crear usuario</h4>
        </div>
        <form @submit.prevent="register" class="card-body">
            <div class="mb-3">
                <label for="name">Nombre:</label>
                <input type="text" id="name" v-model="name" required class="form-control">
                <p v-if="errors.name" class="alert alert-danger" role="alert">{{ errors.name.join(', ') }}</p>
            </div>
            <div class="mb-3">
                <label for="email">Email:</label>
                <input type="email" id="email" v-model="email" required class="form-control">
                <p v-if="errors.email" class="alert alert-danger" role="alert">{{ errors.email.join(', ') }}</p>
            </div>
            <div class="mb-3">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" v-model="password" required class="form-control">
                <p v-if="errors.password" class="alert alert-danger" role="alert">{{ errors.password.join(', ') }}</p>
            </div>
            <div class="mb-3">
                <label for="password_confirmation">Confirmar contraseña:</label>
                <input type="password" id="password_confirmation" v-model="passwordConfirmation" class="form-control">
                <p v-if="errors.password_confirmation" class="alert alert-danger" role="alert">{{ errors.password_confirmation.join(', ') }}</p>
            </div>
            <div>
                <router-link to="/users" class="btn btn-danger float-start" role="button">Volver</router-link>
                <button type="submit" class="btn btn-primary float-end">Crear Usuario</button>
            </div>
        </form>
    </div>
</template>
  
<script>
    import { ref } from 'vue';
    import { useRouter } from 'vue-router';
    import { registerUser } from '../../composables/users';

    export default {
        setup() {
            const name = ref('');
            const email = ref('');
            const password = ref('');
            const passwordConfirmation = ref('');
            const router = useRouter();
            const errors = ref({});

            const register = async () => {
                try {
                    const response = await registerUser({ 
                        name: name.value, 
                        email: email.value, 
                        password: password.value,
                        password_confirmation: passwordConfirmation.value 
                    });
                    Swal.fire({
                        position: "top-end",
                        toast: true,
                        icon: "success",
                        title: response.data.user_message,
                        showConfirmButton: false,
                        timer: 2000
                    });
                    router.push('/');
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

            return { name, email, password, passwordConfirmation, errors, register };
        },
    };
</script>