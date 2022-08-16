import {useToast} from "vue-toast-notification";


class ToastService {
    showSuccessToast(serverMessage) {
        const toast = useToast();
        toast.open({
            message: serverMessage,
            type: "success",
            duration: 5000,
            position: 'top',
            dismissible: true
        })
    }
}
export default new ToastService();
