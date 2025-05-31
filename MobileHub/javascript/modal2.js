function abrirFormModal() {
    // Pega o elemento modal pelo id
    const modalForm = document.getElementById('modal-form');

    // Exibe o modal adicionando a classe 'abrir'
    modalForm.classList.add('abrir');

    // Evento para fechar o modal quando clicar no fundo ou no botão de fechar
    modalForm.addEventListener('click', (e) => {
        if (e.target.id === 'fechar' || e.target.id === 'modal-form') {
            modalForm.classList.remove('abrir'); // Remove a classe 'abrir' para esconder o modal
        }
    })
}

function abrirExcluirModal() {
    // Pega o elemento modal pelo id
    const modalExcluir = document.getElementById('modal-excluir');

    // Exibe o modal adicionando a classe 'abrir'
    modalExcluir.classList.add('abrir');

    // Evento para fechar o modal quando clicar no fundo ou no botão de fechar
    modalExcluir.addEventListener('click', (e) => {
        if (e.target.id === 'fechar' || e.target.id === 'modal') {
            modalExcluir.classList.remove('abrir'); // Remove a classe 'abrir' para esconder o modal
        }
    })
}