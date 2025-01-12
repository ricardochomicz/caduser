@props([
    'id' => '',
    'title' => 'Register',
    'type' => '',
    'msg_delete' => '',
    'msg_inactive' => '',
])
<div>
    <div id="id01" class="modal">
        <span onclick="document.getElementById('id01').style.display='none'" class="close"
            title="Close Modal">&times;</span>
        <div class="modal-content">
            <h1>{{ $title }}</h1>
            <p class="mt-3 mb-3">Você gostaria de deletar o usuário?
                <b id="titleRegister"></b>
            </p>

            <div class="clearfix">
                <button onclick="document.getElementById('id01').style.display='none'" type="button"
                    class="btn btn-secondary cancelbtn">Cancelar</button>
                <form action="" method="post" class="flex items-center">
                    @csrf
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-danger deletebtn">Sim,
                        <span class="labelBody">ativar</span></button>
                </form>

            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        function activeInactive(route, label, register, method = 'DELETE') {
            // Atualizar mensagens
            $('#msg_inactive').hide();
            if (label === 'inactive' || label === 'deletar') {
                $('#msg_inactive').show();
            }

            // Atualizar textos do modal
            label = label.toLowerCase();
            $('#labelTitle').html(label[0].toUpperCase() + label.substr(1));
            $('.labelBody').html(label);
            $('#titleRegister').html(register);

            // Atualizar o atributo `action` do formulário
            let form = document.querySelector('#id01 form');
            form.setAttribute('action', route);

            let methodInput = form.querySelector('input[name="_method"]');
            if (methodInput) {
                methodInput.setAttribute('value', method);
            }

            // Mostrar o modal
            var modal = document.getElementById('id01');
            modal.style.display = 'block';

            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }


        }
    </script>
@endpush
