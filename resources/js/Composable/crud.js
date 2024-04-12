import {router} from "@inertiajs/vue3";
import {ElMessage, ElMessageBox} from 'element-plus'
export function useCrud(id){
    const submitForm = (form, submit_link) => {
        return new Promise((resolve, reject) => {
            if (form.id) {
                form.patch(route(submit_link,form.id)),{
                onSuccess: () => {
                     form.reset()
                   cc
                },
                onError:() =>{
                    ElMessage({
                        title: 'Error',
                        message: 'Oops, something went wrong',
                        type: 'error',
                    })
                },
            }
            }else{
                form.post(route(submit_link)),{
                    onSuccess: () => {
                        form.reset()
                        ElMessage({
                                title: 'Success',
                                message: 'Record successfully updated',
                                type: 'success',
                        })
                    },
                    onError:() =>{
                        ElMessage({
                            title: 'Error',
                            message: 'Oops, something went wrong',
                            type: 'error',
                        })
                    },
            }
            }
        });
    }
    const destroy = (destroy_link) => {

        ElMessageBox.confirm(
            'You will permanently delete this record. Continue?',
            'Warning',
            {
                confirmButtonText: 'Yes',
                cancelButtonText: 'Cancel',
                type: 'warning',
            }
        )
            .then(() => {
                router.delete(destroy_link, {
                    onSuccess: () => {
                        ElMessage({
                            title: 'Success',
                            message: "Successfully Deleted.",
                            type: 'success',
                        })
                    },
                    onError: () => {
                        ElMessage({
                            title: 'Error',
                            message: 'Oops, something went wrong',
                            type: 'error',
                        })
                    }
                })
            })
            .catch(() => {
                ElMessage({
                    type: 'info',
                    message: "Action Canceled.",
                })
            })
    }
     return {
        submitForm,
        destroy
    }
}
