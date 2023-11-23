import api from '../services/api';
import type { Product } from '@/interfaces/product';

export async function getProducts() {
    const response = await api.get('/products');
    return response.data;
}

export async function addProducts(data: Product) {
    const response = await api.post('/products', data);
    return response.data;
}

export async function updateProduct(data: Product, id: string) {
    const response = await api.put(`/products/${id}`, data);
    return response.data;
}

export async function deleteProduct(id: string) {
    const response = await api.delete(`/products/${id}`);
    return response.data;
}