<p align="center"><a href="https://appmax.com.br" target="_blank"><img src="https://scontent-gru2-2.xx.fbcdn.net/v/t39.30808-6/229240497_1910433002463370_3980053956259028089_n.png?_nc_cat=105&ccb=1-5&_nc_sid=09cbfe&_nc_eui2=AeH9ppgGX4ySIjTgfyVbzlh4_Ag4VtQHqxr8CDhW1AerGrSVqeJjmOIqXIAvuZC4jbtdnDVq58Ljjr8h5BePeQJs&_nc_ohc=qC3SGW7AQr8AX-HFycG&_nc_ht=scontent-gru2-2.xx&oh=00_AT_nSpP_gngErdHKIEpwRBCv3LP_lhtQ0aChI0T3ZCiiTg&oe=62296A03" width="200"></a></p>

# Desafio Técnico Full-stack

Projeto desenvolvido para o processo seletivo da Appmax.
> Documentação: [https://documenter.getpostman.com/view/19595551/UVkvJsNM](https://documenter.getpostman.com/view/19595551/UVkvJsNM)

## Criar uma API para realizar as seguintes ações:

- Cadastro de produtos com os seguintes campos obrigatórios.
- Movimentação de produtos.
- Histórico.

## Tecnologias utilizadas

- **PHP**: 8.1.3
- **Laravel**: 9.3.1
- **Composer**: 2.2.7
- **Node**: v16.13.2
- **NPM**: 8.5.3

## Instalação
> Antes de iniciar, crie um banco de dados. Neste exemplo estamos utilizando o nome app-7rz2ot9w, mas fica a vontade para usar o nome que preferir.

*1. Clonar repositório*
```
git clone https://github.com/Colorio/app-7rz2ot9w.git
```
*2. Acessar pasta do projeto*
```
cd app-7rz2ot9w.git
```
*3. Criar arquivo .env (Windows | macOS - Linux)*
```
copy .env.example .env | cp .env.example .env
```
*4. Intalar*
```
composer install
```
*5. Executar as migrations*
```
php artisan migrate
```