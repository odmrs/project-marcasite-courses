<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    cardNumber: '',
    expiryDate: '',
    cvc: '',
    remember: false
});

const submit = () => {
    form.post(route('stripe.checkout'), {
        onFinish: () => form.reset(),
    });
}
</script>


<template>
    <div class="antialiased bg-gray-100 text-gray-600 min-h-screen p-4">
        <div class="h-full">
            <form @submit.prevent="submit">
                <div>
                    <!-- Card background -->
                    <div class="relative px-4 sm:px-6 lg:px-8 max-w-lg mx-auto">
                        <img class="rounded-t shadow-lg" src="https://preview.cruip.com/mosaic/images/pay-bg.jpg" width="460" height="180" alt="Pay background" />
                    </div>
                    <!-- Card body -->
                    <div class="relative px-4 sm:px-6 lg:px-8 pb-8 max-w-lg mx-auto">
                        <div class="bg-white px-8 pb-6 rounded-b shadow-lg">
                            <!-- Card header -->
                            <div class="text-center mb-6">
                                <div class="mb-2">
                                    <img class="-mt-8 inline-flex rounded-full" src="../../../../storage/app/public/images/logo.jpeg" width="64" height="64" alt="User" />
                                </div>
                                <h1 class="text-xl leading-snug text-gray-800 font-semibold mb-2">(NOME DO CURSO)</h1>
                                <div class="text-sm">
                                    (DESCRIÇÂO DO CURSO)
                                </div>
                            </div>
                            <!-- Toggle -->
                            <div class="flex justify-center mb-6">
                                <div class="relative flex w-full p-1 bg-gray-50 rounded">
                                    <button class="relative flex-1 text-sm font-medium p-1 transition duration-150 ease-in-out focus:outline-none focus-visible:ring-2">Pagamento Em Cartão</button>
                                </div>
                            </div>
                            <div x-show="card">
                                <div class="space-y-4">
                                    <!-- Card Number -->
                                    <div>
                                        <label class="block text-sm font-medium mb-1" for="cardNumber">Card Number <span class="text-red-500">*</span></label>
                                        <input v-model="cardNumber" id="cardNumber" class="text-sm text-gray-800 bg-white border rounded leading-5 py-2 px-3 border-gray-200 hover:border-gray-300 focus:border-indigo-300 shadow-sm placeholder-gray-400 focus:ring-0 w-full" type="text" placeholder="4242 4242 4242 4242" />
                                    </div>
                                    <!-- Expiry and CVC -->
                                    <div class="flex space-x-4">
                                        <div class="flex-1">
                                            <label class="block text-sm font-medium mb-1" for="expiryDate">Validade <span class="text-red-500">*</span></label>
                                            <input v-model="expiryDate" id="expiryDate" class="text-sm text-gray-800 bg-white border rounded leading-5 py-2 px-3 border-gray-200 hover:border-gray-300 focus:border-indigo-300 shadow-sm placeholder-gray-400 focus:ring-0 w-full" type="text" placeholder="MM/AA" />
                                        </div>
                                        <div class="flex-1">
                                            <label class="block text-sm font-medium mb-1" for="cvc">CVC <span class="text-red-500">*</span></label>
                                            <input v-model="cvc" id="cvc" class="text-sm text-gray-800 bg-white border rounded leading-5 py-2 px-3 border-gray-200 hover:border-gray-300 focus:border-indigo-300 shadow-sm placeholder-gray-400 focus:ring-0 w-full" type="text" placeholder="CVC" />
                                        </div>
                                    </div>
                                </div>
                                <!-- Form footer -->
                                <div class="mt-6">
                                    <div class="mb-4">
                                        <button type="submit" class="font-medium text-sm inline-flex items-center justify-center px-3 py-2 border border-transparent rounded leading-5 shadow-sm transition duration-150 ease-in-out w-full bg-indigo-500 hover:bg-indigo-600 text-white focus:outline-none focus-visible:ring-2">Pagar (valor)</button>
                                    </div>
                                </div>
                            </div>
                            <div x-show="!card" x-cloak>
                                <div>
                                    <div class="text-xs text-gray-500 italic text-center">Será descontado da sua conta R$: (valor)</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

