<div>
    <div x-data="{ success: @entangle('success') }" class="mt-8 bg-white p-6 rounded-xl shadow border">

        <h3 class="text-lg font-semibold mb-4">Atendimento</h3>

        <form 
            wire:submit.prevent="send" 
            class="space-y-4" 
            x-show="!success"
            x-transition.opacity.duration.500ms
        >

            <input type="hidden" wire:model="empresa.id">

            <div>
                <input 
                    type="text"
                    wire:model.defer="nome"
                    placeholder="Nome"
                    class="w-full border rounded px-3 py-2"
                >
                @error('nome') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <input 
                    type="email"
                    wire:model.defer="email"
                    placeholder="Email"
                    class="w-full border rounded px-3 py-2"
                >
                @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <textarea 
                    wire:model.defer="mensagem"
                    placeholder="Mensagem"
                    rows="5"
                    class="w-full border rounded px-3 py-2"
                ></textarea>
                @error('mensagem') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <button 
                type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
                wire:loading.attr="disabled"
            >
                <span wire:loading.remove>Enviar Mensagem</span>
                <span wire:loading>Enviando...</span>
            </button>

        </form>

        <!-- SUCESSO -->
        <div x-show="success"
            x-transition.opacity.duration.500ms
            class="mt-6 p-4 rounded-lg bg-green-100 border border-green-300 text-green-800">
            ✅ Mensagem enviada com sucesso! 
            <br>
            Entraremos em contato em breve.
        </div>
    </div>
</div>
