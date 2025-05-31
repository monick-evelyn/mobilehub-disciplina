function abrirFormModal() {

    // Pega o elemento modal pelo id
    const modal = document.getElementById('form-modal');

    // Exibe o modal adicionando a classe 'abrir'
    modal.classList.add('abrir');

    // Evento para fechar o modal quando clicar no fundo ou no botão de fechar
    modal.addEventListener('click', (e) => {
        if (e.target.id === 'fechar' || e.target.id === 'form-modal') {
            modal.classList.remove('abrir'); // Remove a classe 'abrir' para esconder o modal
        }
    })
}