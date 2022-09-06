<template>
    <div
        class="modal"
        id="deleting-confirmation"
        tabindex="-1"
    >
        <div class="modal-dialog">
            <div class="modal-content border-0">
                <div class="modal-header">
                    <h5
                        class="modal-title"
                    >
                        Are you sure you want to delete your account?
                    </h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    />
                </div>

                <div
                    class="modal-footer d-flex justify-content-center"
                >
                    <button
                        type="button"
                        data-bs-dismiss="modal"
                    >
                        No
                    </button>
                    <button
                        class="close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                        data-bs-target="#deleting-confirmation"
                        @click="triggerDeletingUserAccount"
                    >
                        Yes
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import TokenService from "../services/token.service";
import UserService from "../services/user-service";

export default {
    name: "UserAccountDeletingConfirmationModalComponent",
    methods: {
        async triggerDeletingUserAccount() {
            await UserService.deleteUserAccount()
            await TokenService.removeUser()
            this.$router.push('/auth')
        }
    }
}
</script>

