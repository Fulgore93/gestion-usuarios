<template>
    <div class="card">
        <div class="card-header">
            <h4>Listado de usuarios
                <router-link to="/users/create" class="btn btn-primary float-end" role="button">Crear</router-link>
            </h4>
        </div>                    
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Email</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in users" :key="user.id">
                        <td>{{ user.id }}</td>
                        <td>{{ user.name }}</td>
                        <td>{{ user.email }}</td>
                        <td>
                            <router-link :to="`users/show/${user.id}`" class="btn btn-info btn-sm" role="button">Detalle</router-link> 
                            <router-link :to="`users/edit/${user.id}`" class="btn btn-success btn-sm" role="button">Editar</router-link>
                            <button @click="confirmDelete(user.id)" type="button" class="btn btn-danger btn-sm">Eliminar</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
  
<script>
    import { ref, onMounted } from 'vue';
    import { getUsers, deleteUser } from '../../composables/users';

    export default {
        setup() {
            const users = ref([]);
            const token = localStorage.getItem('token');

            const userList = async () => {
                try {
                    const response = await getUsers(token);
                    users.value = response.data.data;
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
            };
            
            const confirmDelete = (userId) => {
                Swal.fire({
                    title: '¿Está seguro de eliminar este usuario?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Confirmar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        destroy(userId);
                    }
                });
            };

            const destroy = async (userId) => {
                try {
                    const response = await deleteUser(token, userId);
                    userList();
                    Swal.fire({
                        position: "top-end",
                        toast: true,
                        icon: "success",
                        title: response.data.user_message,
                        showConfirmButton: false,
                        timer: 2000
                    });
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
            };

            onMounted(() => {
                userList();
            });
            return { users, confirmDelete };
        },
    };
</script>