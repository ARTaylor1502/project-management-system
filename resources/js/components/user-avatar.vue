<template>
    <div>
        <img v-if="avatar_url" class="avatar" :src="avatar_url" :alt="user_full_name" :title="user_full_name">
        <i v-if="!avatar_url" class="avatar-placeholder fal fa-user" :title="user_full_name"></i>
    </div>
</template>

<script>
    export default {
        name: "user-avatar",
        props: ['user_id', 'user_full_name'],
        data() {
            return {
                avatar_url: false
            }
        },
        mounted() {
          this.loadAvatar();
        },
        methods: {
            loadAvatar() {
                let self = this;

                axios.get(this.$route('api.user.avatar', this.user_id))
                .then(response => {
                    self.avatar_url = response.data;
                }).catch(function (error) {
                    console.log(error);
                });
            }
        }
    }
</script>
