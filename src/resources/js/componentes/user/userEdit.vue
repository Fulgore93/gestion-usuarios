<template>
    <div class="card">
        <div class="card-header">
            <h4>Editar usuario</h4>
        </div>
        <form @submit.prevent="edit" v-if="user" class="card-body">
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
            <div>
                <router-link to="/users" class="btn btn-danger float-start" role="button">Volver</router-link>
                <button type="submit" class="btn btn-primary float-end">Actualizar Usuario</button>
            </div>
        </form>
    </div>
</template>
  
<script>
    import { ref, onMounted } from 'vue';
    import { useRoute, useRouter } from 'vue-router';
    import { editUser } from '../../composables/users';
    import { getUser } from '../../composables/users';

    export default {
        setup() {
            const user = ref(null);
            const route = useRoute();
            const router = useRouter();
            const errors = ref({});
            const userId = route.params.id;
            const token = localStorage.getItem('token');

            onMounted(async () => {
                try {
                    const response = await getUser(token,userId);
                    user.value = response.data.data;
                } catch (error) {
                    if (error.response && error.response.data && error.response.data.data) {
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
            });

            const edit = async () => {
                try {
                    const response = await editUser(token, userId, { 
                        name: user.value.name, 
                        email: user.value.email
                    });
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

            return { user, errors, edit };
        },
    };
</script>