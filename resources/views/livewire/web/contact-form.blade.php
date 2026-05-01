<div>
    @if ($enviado)
        <div class="row">
            <div class="col-lg-12">
                @if (session()->has('success'))
                    <div class="alert alert-success error-msg">
                        {{ session('success') }}
                    </div>
                @endif                
            </div>                  
        </div>
    @else
        <form wire:submit="submit" autocomplete="off"> 
            <div class="form-group row">
                <div class="col-lg-4">
                    <label>Nome</label>
                    <!-- HONEYPOT -->
                    <input 
                        type="text"
                        name="cidade"
                        wire:model="cidade"
                        autocomplete="nope"
                        aria-hidden="true"
                        tabindex="-1"
                        style="position: absolute; left: -9999px;" 
                    />
                    <input type="text" class="form-control @error('name') is-invalid @enderror" wire:model.defer="name">
                    @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>                          
                <div class="col-lg-4">
                    <label>Email</label>
                    <input type="text" class="form-control @error('email') is-invalid @enderror" wire:model.defer="email">
                    @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>                          
                <div class="col-lg-4">
                    <label>WhatsApp</label>
                    <input type="text" x-mask="(99) 99999-9999" class="form-control" wire:model.defer="whatsapp">
                </div>                          
            </div>
            <div class="form-group row">
                <div class="col-lg-12">
                    <label>Nos conte um pouco sobre sua empresa</label>
                    <textarea wire:model.defer="message" rows="10" class="form-control @error('message') is-invalid @enderror"></textarea>
                    @error('message') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>                  
            </div>                       
            
            <button type="submit"
                    wire:loading.attr="disabled"
                    class="btn btn-primary flex items-center gap-2">

                <span wire:loading.class="hidden" wire:target="submit">
                    Enviar Agora
                </span>

                <span class="hidden flex items-center gap-2"
                    wire:loading.class.remove="hidden"
                    wire:target="submit">

                    <svg class="animate-spin h-4 w-4" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10" stroke="white" stroke-width="4" fill="none"/>
                    </svg>

                    Enviando...
                </span>

            </button>
        </form>
    @endif    
</div>
