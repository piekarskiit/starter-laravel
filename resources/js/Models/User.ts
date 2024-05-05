
export type User = {
    uuid: string;
    first_name: string;
    last_name: string;
    email: string;
    role: string,
    full_name: string;
    email_verified_at?: string;
}

export type UserForm = {
    first_name: string;
    last_name: string;
    email: string;
    password: string;
    password_confirmation: string;
    role: string;
};
