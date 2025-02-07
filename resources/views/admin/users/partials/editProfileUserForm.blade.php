{{-- Formulario para editar usuario --}}

<div class="row">
    <form action="{{ route('users.updateProfile', Auth::user()->id) }}" method="POST">
        {{-- Foto De perfil Actual --}}
        <div class="col-md-12">
            <div class="card">
                <div class="card-body d-flex justify-content-center align-items-center">
                    <div class="form-group">
                        <label for="photo">Foto de perfil actual</label>
                        <div id="preview" class="text-center"
                            style="width: 200px; height: 200px; border: 1px solid #000; border-radius: 50%;">
                            <img src="" alt="{{ Auth::user()->name }}" class="img-thumbnail">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Foto del perfil --}}
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="photo">Foto de perfil</label>
                        <input type="file" class="form-control" id="photo" name="photo">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                @php
                    $user = Auth::user();
                @endphp
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Nombre</label>
                        <input type="text" class="form-control" id="name-{{ $user->id }}" name="name"
                            value="{{ Auth::user()->name }}">
                    </div>
                    <div class="form-group">
                        <label for="email">Correo Electrónico</label>
                        <input type="email" class="form-control" id="email-{{ $user->email }}" name="email"
                            value="{{ Auth::user()->email }}">
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="password" class="form-control" id="password-profileEdit" name="passwordProfile">
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Confirmar Contraseña</label>
                        <input type="password" class="form-control" id="password_confirmation-profileEdit"
                            name="password_confirmationProfile">
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    // foto del perfil preview

    document.getElementById('photo').onchange = function(e) {
        let reader = new FileReader();
        reader.readAsDataURL(e.target.files[0]);
        reader.onload = function() {
            let preview = document.getElementById('preview');
            image = document.createElement('img');
            image.src = reader.result;
            preview.innerHTML = '';
            preview.append(image);
        }
    }
</script>
