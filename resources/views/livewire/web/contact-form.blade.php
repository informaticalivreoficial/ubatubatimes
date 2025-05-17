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
                    <input type="text" class="form-control @error('name') is-invalid @enderror" wire:model.live="name">
                    @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>                          
                <div class="col-lg-4">
                    <label>Email</label>
                    <input type="text" class="form-control @error('email') is-invalid @enderror" wire:model.live="email">
                    @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>                          
                <div class="col-lg-4">
                    <label>WhatsApp</label>
                    <input type="text" x-mask="(99) 99999-9999" class="form-control" wire:model.live="whatsapp">
                </div>                          
            </div>
            <div class="form-group row">
                <div class="col-lg-12">
                    <label>Nos conte um pouco sobre sua empresa</label>
                    <textarea wire:model.live="message" rows="10" class="form-control @error('message') is-invalid @enderror"></textarea>
                    @error('message') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>                  
            </div>                       
            
            <button wire:click="submit" wire:loading.attr="disabled" class="btn btn-primary">
                <span wire:loading.remove wire:target="submit">Enviar Agora</span>
                <span wire:loading wire:target="submit">Enviando...</span>
            </button>
        </form>
    @endif    
</div>
