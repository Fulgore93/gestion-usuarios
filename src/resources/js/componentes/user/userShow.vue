<template>
    <div v-if="user" class="card-body">
        <div class="card-header">
            <h4>Detalle de usuario</h4>
        </div>
        <div class="mb-3">
            <label>Nombre de usuario</label>
            <p class="form-control">{{ user.name }}</p>
        </div>
        <div class="mb-3">
            <label>Email de usuario</label>
            <p class="form-control">{{ user.email }}</p>
        </div>
        <div>
            <router-link to="/users" class="btn btn-danger float-start" role="button">Volver</router-link>
        </div>
    </div>
</template>
  
<script>
    import { ref, onMounted } from 'vue';
    import { useRoute } from 'vue-router';
    import { getUser } from '../../composables/users';
    
    export default {
        setup() {
            const route = useRoute();
            const user = ref(null);
            const userId = route.params.id;

            onMounted(async () => {
                try {
                    const token = localStorage.getItem('token');
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

            return { user };
        },
    };
</script>