'use strict'

const loginContainer = document.getElementById('login-container')

const moveOverlay = () => loginContainer.classList.toggle('move')

//Mover para tela de login do adm
document.getElementById('admin-button').addEventListener('click', moveOverlay)

//Voltar para tela inicial
document.getElementById('return-button').addEventListener('click', moveOverlay)
document.getElementById('mobile-text').addEventListener('click', moveOverlay)

//Mudar icone do botao
var adminIcon = document.getElementById('admin-icon')
var alunoIcon = document.getElementById('aluno-icon')
var alunoButton = document.getElementById('aluno-button')
var adminButton = document.getElementById('admin-button')

function changeAdminIcon() {
    adminIcon.src = "./img/login/professor-branco.png"
}

function restoreAdminIcon() {
    adminIcon.src = "./img/login/professor-azul.png";
}

function changeAlunoIcon() {
    alunoIcon.src = "./img/login/aluno-branco.png"
}

function restoreAlunoIcon() {
    alunoIcon.src = "./img/login/aluno-azul.png";
}

adminButton.addEventListener('mouseover', changeAdminIcon)
adminButton.addEventListener('mouseout', restoreAdminIcon)
alunoButton.addEventListener('mouseover', changeAlunoIcon)
alunoButton.addEventListener('mouseout', restoreAlunoIcon)
