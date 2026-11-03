/**
 * AURÉA — JavaScript Principal
 * Efeitos de navegação, modais dinâmicos e integrações AJAX seguras
 */

document.addEventListener('DOMContentLoaded', function () {
    // 1. Efeito de Scroll na Barra de Navegação
    const header = document.querySelector('.header-aurea');
    if (header) {
        window.addEventListener('scroll', function () {
            if (window.scrollY > 40) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });
    }

    // 2. Abertura automática do modal de login se houver parâmetro na URL (?login=1)
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('login') === '1') {
        const modalLoginEl = document.getElementById('modalLogin');
        if (modalLoginEl) {
            const modalLogin = new bootstrap.Modal(modalLoginEl);
            modalLogin.show();
        }
    }

    // 3. Máscara de Telefone simples
    const cadTelefone = document.getElementById('cadTelefone');
    if (cadTelefone) {
        cadTelefone.addEventListener('input', function (e) {
            let x = e.target.value.replace(/\D/g, '').match(/(\d{0,2})(\d{0,5})(\d{0,4})/);
            e.target.value = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
        });
    }

    // 4. Envio do Formulário de Login via AJAX
    const formLogin = document.getElementById('formLogin');
    if (formLogin) {
        formLogin.addEventListener('submit', function (e) {
            e.preventDefault();
            const alerta = document.getElementById('alertaLogin');
            const btnSubmit = document.getElementById('btnLoginSubmit');
            const spinner = btnSubmit.querySelector('.spinner-border');
            const btnTexto = btnSubmit.querySelector('.btn-texto');

            alerta.className = 'alert d-none';
            btnSubmit.disabled = true;
            spinner.classList.remove('d-none');
            btnTexto.textContent = 'Autenticando...';

            const formData = new FormData(this);

            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
                .then(res => res.json())
                .then(data => {
                    if (data.sucesso) {
                        alerta.className = 'alert alert-success';
                        alerta.textContent = data.mensagem || 'Login realizado! Redirecionando...';
                        setTimeout(() => {
                            window.location.href = data.redirect || window.location.href;
                        }, 800);
                    } else {
                        alerta.className = 'alert alert-danger';
                        alerta.textContent = data.mensagem || 'E-mail ou senha inválidos.';
                        btnSubmit.disabled = false;
                        spinner.classList.add('d-none');
                        btnTexto.textContent = 'Entrar';
                    }
                })
                .catch(err => {
                    console.error(err);
                    alerta.className = 'alert alert-danger';
                    alerta.textContent = 'Erro ao processar autenticação. Tente novamente.';
                    btnSubmit.disabled = false;
                    spinner.classList.add('d-none');
                    btnTexto.textContent = 'Entrar';
                });
        });
    }

    // 5. Envio do Formulário de Cadastro via AJAX
    const formCadastro = document.getElementById('formCadastro');
    if (formCadastro) {
        formCadastro.addEventListener('submit', function (e) {
            e.preventDefault();
            const alerta = document.getElementById('alertaCadastro');
            const btnSubmit = document.getElementById('btnCadastroSubmit');
            const spinner = btnSubmit.querySelector('.spinner-border');
            const btnTexto = btnSubmit.querySelector('.btn-texto');

            const senha = document.getElementById('cadSenha').value;
            const confSenha = document.getElementById('cadConfSenha').value;

            if (senha !== confSenha) {
                alerta.className = 'alert alert-warning';
                alerta.textContent = 'As senhas informadas não coincidem.';
                return;
            }

            alerta.className = 'alert d-none';
            btnSubmit.disabled = true;
            spinner.classList.remove('d-none');
            btnTexto.textContent = 'Cadastrando...';

            const formData = new FormData(this);

            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
                .then(res => res.json())
                .then(data => {
                    if (data.sucesso) {
                        alerta.className = 'alert alert-success';
                        alerta.textContent = data.mensagem || 'Conta criada com sucesso! Redirecionando...';
                        setTimeout(() => {
                            window.location.href = data.redirect || window.location.href;
                        }, 1000);
                    } else {
                        alerta.className = 'alert alert-danger';
                        alerta.textContent = data.mensagem || 'Não foi possível realizar o cadastro.';
                        btnSubmit.disabled = false;
                        spinner.classList.add('d-none');
                        btnTexto.textContent = 'Criar Conta e Continuar';
                    }
                })
                .catch(err => {
                    console.error(err);
                    alerta.className = 'alert alert-danger';
                    alerta.textContent = 'Erro de comunicação ao criar conta.';
                    btnSubmit.disabled = false;
                    spinner.classList.add('d-none');
                    btnTexto.textContent = 'Criar Conta e Continuar';
                });
        });
    }
});
