# 🌊 Ubatuba Times CMS

[![PHP](https://img.shields.io/badge/PHP-8.1+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net/)
[![Laravel](https://img.shields.io/badge/Laravel-10-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com/)
[![License](https://img.shields.io/badge/license-MIT-green?style=for-the-badge)](https://choosealicense.com/licenses/mit/)

Sistema completo de gerenciamento de conteúdo (CMS) para portais de notícias, classificados e empresas locais.

Inclui módulos de **notícias, anúncios, empresas, planos, faturas e integração com pagamentos**.

---

## 🚀 Funcionalidades

- 📰 Gestão completa de notícias e categorias
- 🏢 Cadastro de empresas e anúncios
- 💳 Planos de assinatura e cobrança
- 🧾 Controle de faturas e pagamentos
- 🔐 Sistema de autenticação e permissões
- 📊 Dashboard administrativo
- 🔌 Integração com gateways de pagamento
- ⚡ Arquitetura modular e escalável

---

## 🛠️ Stack

- PHP 8.1+
- Laravel 10+
- AdminLTE
- Js
- Livewire
- MySQL / MariaDB

---

## 📦 Requisitos

- PHP >= 8.1
- Composer
- Node.js + NPM
- MySQL / MariaDB

---

## ⚙️ Instalação

```bash
git clone https://github.com/informaticalivreoficial/ubatuba-times.git

cd ubatuba-times

composer install

npm install
npm run dev

cp .env.example .env

php artisan key:generate

php artisan migrate --seed