<template>
    <TransitionRoot appear :show="isOpen" as="template">
      <Dialog as="div" @close="closeModal" class="relative z-[50]">
        <TransitionChild
          as="template"
          enter="duration-300 ease-out"
          enter-from="opacity-0"
          enter-to="opacity-100"
          leave="duration-200 ease-in"
          leave-from="opacity-100"
          leave-to="opacity-0"
        >
        <div class="fixed inset-0 bg-black bg-opacity-80" />
        </TransitionChild>
  
        <div class="fixed inset-0 overflow-y-auto">
          <div class="flex min-h-full items-center justify-center p-4">
            <TransitionChild
              as="template"
              enter="duration-300 ease-out"
              enter-from="opacity-0 scale-95"
              enter-to="opacity-100 scale-100"
              leave="duration-200 ease-in"
              leave-from="opacity-100 scale-100"
              leave-to="opacity-0 scale-95"
            >
              <DialogPanel class="flex w-full max-w-2xl transform overflow-hidden rounded-2xl bg-white p-6 shadow-xl transition-all">
                              
                <form @submit.prevent="submitForm" class="mx-auto w-full">
                  <div class="mb-5">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Nombre</label>
                    <input type="text" id="name" v-model="formData.name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 ">
                    <p v-if="errors.name" class="text-red-500 text-sm mb-2">{{ errors.name[0] }}</p>
                  </div>
                  <div class="mb-5 ">
                    <label for="price" class="block mb-2 text-sm font-medium text-gray-900">Precio</label>
                    <input type="text" id="price" v-model="formData.price" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 ">
                    <p v-if="errors.price" class="text-red-500 text-sm mb-2">{{ errors.price[0] }}</p>
                  </div>
                  <div class="mb-5 ">
                    <label for="description" class="block mb-2 text-sm font-medium text-gray-900">Descripcion</label>
                    <input type="text" id="description" v-model="formData.description" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 ">
                    <p v-if="errors.description" class="text-red-500 text-sm mb-2">{{ errors.description[0] }}</p>
                  </div>
                  <div class="mb-5 ">
                    <label for="image" class="block mb-2 text-sm font-medium text-gray-900">Enlace de la Imagen</label>
                    <input type="text" id="image" v-model="formData.image" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 ">
                    <p v-if="errors.image" class="text-red-500 text-sm mb-2">{{ errors.image[0] }}</p>
                  </div>

                  <div class="flex justify-center w-full">
                      <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm sm:w-auto px-5 py-2.5">Actualizar</button>
                  </div>
                  <h1 class="text-white">{{ count }}</h1>
                </form>
              </DialogPanel>
            </TransitionChild>
          </div>
        </div>
      </Dialog>
    </TransitionRoot>
  </template>
  
<script setup lang="ts">
import { ref , } from 'vue';
import { TransitionRoot, TransitionChild, Dialog, DialogPanel } from '@headlessui/vue';
import type { Product, FormErrors } from '../interfaces/product';
import { updateProduct } from '@/backend/products';

const props = defineProps({
    id: String
});

const isOpen = ref<boolean>(true);
function closeModal(): void {
  isOpen.value = false;
}

const count = ref(0);
function increment() {
  count.value++
}

let errors = ref<FormErrors>({});

const formData = ref<Product>({
  name: '',
  price: '',
  description: '',
  image: ''
});

async function submitForm(): Promise<void> {
  errors.value = {};
  try {

    await updateProduct(formData.value, props.id);
    closeModal();
    window.location.reload();

  } catch (error: any) {
    errors = { ...error.response.data } || {};
    increment();

  }
}

</script>