export interface Product{
    name: string;
    price: string;
    description: string;
    image: string;
}

export interface FormErrors {
    [key: string]: string;
};