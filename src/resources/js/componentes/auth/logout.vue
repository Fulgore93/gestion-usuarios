<template>
    <button @click="logout" type="button" class="btn btn-light">Cerrar Sesión</button>
</template>

<script>
    import { useRouter } from 'vue-router';
    import { isAuthenticated } from '../../events/eventLogin';

    export default {
        setup() {
            const router = useRouter();

            const logout = () => {
                isAuthenticated.value = false;
                localStorage.removeItem('token');
                localStorage.removeItem('userEmail');
                router.push('/');
            };

            return { logout };
        },
    };
</script>