<script setup lang="ts">
import { getProducts } from './backend/products';
import { ref, onMounted, toRef } from 'vue';
import agregarModal from './components/agregarModal.vue';
import { deleteProduct } from './backend/products';
import editModal from './components/editModal.vue';



async function deleteP(id: string){
    await deleteProduct(id);
    window.location.reload();
}

const showAddModal = ref(false);
const showEditModal = ref(false);
let modalId = '';

const products = ref([]);

function openAddModal() {
  showAddModal.value = true;
}

function openEditModal(id: string) {
    showEditModal.value = true;
    modalId = id;
}

onMounted(async () => {
  products.value = await getProducts();

});





</script>

<template>
    <agregarModal v-if="showAddModal" @close="showAddModal = false"></agregarModal>
    <editModal v-if="showEditModal" @close="showEditModal = false, modalId = ''" :id=modalId></editModal>
    <header class="flex bg-zinc-800 text-white p-3">
        <button @click="openAddModal">
            Agregar
        </button>

    </header>

    <section>
        <ul class="flex flex-wrap justify-center">
            <div class="border-2 border w-[250px] m-5 rounded-md" v-for="(product) in products">
                <li class="text-center">
                    <img :src="product.image" class="flex h-[200px] w-[200px] p-2 mx-auto">
                    <div class="flex w-full text-center">
                      <h1 class="font-bold mt-2 mx-auto" >
                        {{ product.name }} - ${{ product.price }}
                      </h1>
                    </div>
                    <p class="m-2">
                        {{ product.description }}
                    </p>
                    <button @click="openEditModal(product.id)" class="bg-green-500 text-white mx-3 rounded-lg p-1 my-5">
                        Editar
                    </button>
                    <button @click="deleteP(product.id)" class="bg-red-500 text-white mx-3 rounded-lg p-1 my-5">
                        Eliminar
                    </button>
                </li>
            </div>

        </ul>
    </section>
</template>

