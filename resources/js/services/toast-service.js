import {useToast} from "vue-toast-notification";


class ToastService {
    showToast(serverMessage, type) {
        //const type = "success"
        const toast = useToast();
        toast.open({
            message: serverMessage,
            type: type,
            duration: 5000,
            position: 'top',
            dismissible: true
        })
    }
}
export default new ToastService();
