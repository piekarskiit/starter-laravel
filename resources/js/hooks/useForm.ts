import {useForm as useFormInertia} from "@inertiajs/vue3";
import * as pkg from "vue-toastification"
import type {Page} from "@inertiajs/core";
import {isNull, omitBy} from "lodash";

const { useToast } = pkg
export function useForm<TForm extends Record<string, unknown>>(
    formData: { last_name: string; first_name: string; email: string },
    url: string,
    method: "post" | "put" | "patch" | "delete" = "put",
    options?: {}
) {
    const toast = useToast();
    toast.info('Hello world!')

    const defaultOptions = {
        onSuccess: (page: Page) => {
            if (page.props.message) {
                toast.success(page.props.message);
            }
        },
        onError: (errors: Record<string, string>) => {
            if (errors) {
                toast.error(Object.values(errors)[0]);
            }
        },
        ...options,
    };

    const form = useFormInertia(formData);

    const submit = () => {
        form
            ?.transform((data) => omitBy(data as object, isNull))
            .submit(method, url, defaultOptions);
    };

    return {
        form,
        submit,
    };
}
