# FlexCommerce - Roadmap de Desenvolvimento

## Visão Geral do Projeto

E-commerce customizável construído com TALL Stack (Tailwind, Alpine.js, Laravel, Livewire) + Filament para administração.

**Objetivo**: Criar um sistema de e-commerce que permite personalização completa (cores, logo, layout) para revenda.

**Stack Principal**:
- **Backend/Admin**: Laravel 12 + Filament v4
- **Frontend**: Livewire v3 + Flux UI + Tailwind CSS v4
- **Integrações Abstraídas** (sistema multi-provedor):
  - **Frete**: Melhor Envio (padrão), Correios, Jadlog, Loggi, Kangu
  - **Pagamento**: Mercado Pago, Stripe, Asaas, PagSeguro, Pagar.me
  - **Nota Fiscal**: Focus NFe, eNotas, NFe.io, WebMania

---

## Fase 1: Fundação e Estrutura Base (1-2 semanas)

### 1.1 Configuração do Banco de Dados
- [ ] Criar migrations para tabelas principais:
  - `products` (produtos)
  - `categories` (categorias)
  - `product_images` (imagens dos produtos)
  - `product_variants` (variações: tamanho, cor, etc)
  - `inventory` (estoque)
  - `orders` (pedidos)
  - `order_items` (itens do pedido)
  - `customers` (clientes - separado de users)
  - `addresses` (endereços de entrega)
  - `coupons` (cupons de desconto)
  - `reviews` (avaliações de produtos)
  - `payment_transactions` (transações de pagamento)
  - `invoices` (notas fiscais)
  - `shipping_labels` (etiquetas de envio)
  - `pages` (páginas CMS - institucionais)

### 1.2 Sistema de Personalização
- [ ] Criar tabela `settings` para armazenar configurações customizáveis
- [ ] Implementar campos:
  - Logo do site
  - Cores primárias/secundárias (Tailwind CSS)
  - Nome da loja
  - Informações de contato
  - Redes sociais
  - Termos de uso / Política de privacidade
  - **Tema/Design selecionado** (theme_id)
- [ ] Criar tabela `themes` para templates de frontend
- [ ] Criar tabela `banners` para gestão de banners
- [ ] Criar Resource Filament para gerenciar Settings

### 1.3 Configurações Fiscais e Dados do Produto
- [ ] Adicionar campos fiscais em `products`:
  - NCM (Nomenclatura Comum do Mercosul)
  - CFOP (Código Fiscal de Operações)
  - Origem da mercadoria
  - CEST (Código Especificador da Substituição Tributária)
  - Alíquotas de impostos (ICMS, PIS, COFINS)
  - Peso e dimensões (para frete)

### 1.4 Models e Relationships
- [ ] Criar models com relacionamentos corretos
- [ ] Implementar Factories para testes
- [ ] Criar Seeders com dados de exemplo

---

## Fase 2: Painel Administrativo (Filament) (2-3 semanas)

### 2.1 Gestão de Produtos
- [ ] **Product Resource** (Filament):
  - CRUD completo de produtos
  - Upload de múltiplas imagens
  - Editor rico para descrição
  - Gestão de variações (tamanho, cor, etc)
  - Controle de estoque
  - **Campos fiscais** (NCM, CFOP, CEST, impostos)
  - **Peso e dimensões** (para cálculo de frete)
  - SEO (meta title, description, slug)
  - Status (ativo/inativo, destaque)
  - Permitir avaliações (sim/não)

### 2.2 Gestão de Categorias
- [ ] **Category Resource**:
  - Hierarquia de categorias (parent/child)
  - Imagem da categoria
  - Ordenação personalizada
  - Status (ativo/inativo)

### 2.3 Gestão de Pedidos
- [ ] **Order Resource**:
  - Visualização de pedidos
  - Status do pedido (pendente, pago, enviado, entregue, cancelado)
  - Informações do cliente
  - Itens do pedido
  - Valor total, frete, descontos
  - Rastreamento de envio
  - Notas internas

### 2.4 Gestão de Clientes
- [ ] **Customer Resource**:
  - Visualização de clientes
  - Histórico de pedidos
  - Endereços salvos
  - Relatórios de compras

### 2.5 Cupons de Desconto
- [ ] **Coupon Resource**:
  - Tipos: percentual, valor fixo, frete grátis
  - Validade (datas início/fim)
  - Limite de uso
  - Valor mínimo de compra
  - Produtos/categorias específicos

### 2.6 Gestão de Banners
- [ ] **Banner Resource** (Filament):
  - Upload de imagem (web e mobile separados)
  - Título e descrição
  - Link/CTA
  - Ordenação (drag & drop)
  - Período de exibição (data início/fim)
  - Status (ativo/inativo)
  - Posição (homepage, categorias, produto, etc)
  - Preview por dispositivo (web/mobile)

### 2.7 Gestão de Temas/Designs
- [ ] **Theme Manager** (Filament):
  - Visualização dos 5 templates disponíveis
  - Preview com screenshots
  - Seleção do tema ativo
  - Customização de cores por tema
  - Configurações específicas do tema (layout, espaçamento, etc)

### 2.8 CMS - Páginas Institucionais
- [ ] **Page Resource** (Filament):
  - Editor WYSIWYG (Rich Text)
  - Páginas padrão:
    - Sobre nós
    - Termos de uso
    - Política de privacidade
    - Política de troca/devolução
    - FAQ
    - Contato
  - Slug personalizado
  - SEO (meta tags)
  - Status (publicado/rascunho)
  - Ordenação no menu

### 2.9 Sistema de Avaliações
- [ ] **Review Resource** (Filament):
  - Visualizar avaliações de clientes
  - Moderação (aprovar/rejeitar)
  - Responder avaliações
  - Filtros por produto/nota
  - Marcar como útil/spam

### 2.10 Configurações da Loja
- [ ] **Settings Page** (Filament) - Multi-tabs:

  **Aba: Informações Gerais**
  - Nome da loja, logo, favicon
  - Informações de contato
  - Redes sociais
  - Seleção de tema/design

  **Aba: Configurações Fiscais**
  - CNPJ, Razão Social, Inscrição Estadual
  - Regime tributário
  - Endereço fiscal completo
  - Certificado digital (upload)

  **Aba: Frete (Sistema Abstraído)**
  - Provedor padrão: [Dropdown]
  - Configurações por provedor:
    - ☑ Melhor Envio (token, transportadoras habilitadas)
    - ☐ Correios Direto (contrato, user, senha)
    - ☐ Jadlog (token, contrato)
    - ☐ Loggi (API key, cidades)
    - ☐ Kangu (token)
  - Endereço de origem (CEP, endereço)
  - Frete grátis (valor mínimo, estados)
  - Prazo adicional de manipulação

  **Aba: Pagamento (Sistema Abstraído)**
  - Gateways habilitados:
    - ☑ Mercado Pago (public key, access token, métodos)
    - ☑ Stripe (public/secret key, métodos)
    - ☐ Asaas (API key, métodos)
    - ☐ PagSeguro (email, token)
    - ☐ Pagar.me (API key)
  - Configurações de parcelamento
  - Taxa de conveniência (opcional)

  **Aba: Nota Fiscal (Sistema Abstraído)**
  - Provedor de NFe: [Dropdown]
  - Configurações por provedor:
    - ☑ Focus NFe (token, ambiente)
    - ☐ eNotas (API key)
    - ☐ NFe.io (API key)
    - ☐ WebMania (consumer key/secret)
  - Emissão automática (após pagamento confirmado)
  - Série da nota fiscal
  - Número inicial

  **Aba: E-mails**
  - Templates de e-mails transacionais
  - SMTP config

### 2.11 Relatórios e Dashboard
- [ ] Dashboard com widgets:
  - Vendas do dia/mês/ano
  - Pedidos pendentes
  - Produtos mais vendidos
  - Clientes novos
  - Gráficos de vendas
  - Ticket médio
  - Taxa de conversão

- [ ] **Relatórios Avançados**:
  - Relatório de vendas (filtros por período, produto, categoria)
  - Relatório de estoque
  - Relatório financeiro
  - Relatório fiscal (para contabilidade)
  - Exportação (PDF, Excel)

---

## Fase 3: Frontend (Loja) - TALL Stack (3-4 semanas)

### 3.1 Sistema de Themes (5 Designs)
- [ ] **Estrutura de Themes**:
  - Criar diretório `resources/views/themes/`
  - Cada tema em subdiretório próprio:
    - `themes/modern/` - Design moderno e minimalista
    - `themes/classic/` - Design clássico e tradicional
    - `themes/bold/` - Design ousado com cores vibrantes
    - `themes/minimal/` - Design ultra-minimalista
    - `themes/elegant/` - Design elegante e sofisticado
  - Componentização: cada tema usa os mesmos componentes Livewire mas com layouts diferentes
  - Sistema de detecção automática do tema ativo via Settings

### 3.2 Páginas Principais (implementadas em todos os themes)
- [ ] **Homepage**:
  - Banner principal responsivo (carrossel web/mobile)
  - Banners secundários (gestão via Filament)
  - Produtos em destaque
  - Categorias
  - Produtos mais vendidos
  - Depoimentos (opcional)
  - Layout adaptável ao tema selecionado

- [ ] **Página de Categoria**:
  - Listagem de produtos
  - Filtros (preço, cor, tamanho, etc)
  - Ordenação (preço, nome, relevância)
  - Paginação

- [ ] **Página do Produto**:
  - Galeria de imagens (zoom)
  - Seleção de variações
  - Quantidade
  - Adicionar ao carrinho
  - Descrição completa (tabs: descrição, especificações, informações)
  - Produtos relacionados
  - **Sistema de avaliações**:
    - Exibir avaliações de clientes
    - Média de estrelas
    - Formulário para avaliar (após compra)
    - Upload de fotos (opcional)
    - Filtros por estrelas

- [ ] **Busca**:
  - Busca de produtos
  - Sugestões em tempo real
  - Filtros

### 3.3 Carrinho de Compras
- [ ] Componente Livewire para carrinho
- [ ] Adicionar/remover produtos
- [ ] Atualizar quantidade
- [ ] Cálculo de subtotal
- [ ] Mini-cart (dropdown no header)
- [ ] Persistência do carrinho (session/database)

### 3.4 Checkout
- [ ] **Multi-step checkout**:
  - Passo 1: Identificação (login/cadastro/guest)
  - Passo 2: Endereço de entrega
  - Passo 3: Cálculo de frete (sistema abstraído - múltiplas opções)
  - Passo 4: Forma de pagamento (sistema abstraído - múltiplos gateways)
  - Passo 5: Revisão e confirmação
- [ ] Aplicar cupom de desconto
- [ ] Cálculo automático de impostos
- [ ] Resumo do pedido atualizado em tempo real

### 3.5 Autenticação de Cliente
- [ ] Registro de cliente
- [ ] Login/Logout
- [ ] Recuperação de senha
- [ ] Área do cliente (minha conta)

### 3.6 Área do Cliente
- [ ] Dashboard
- [ ] Meus pedidos (histórico completo)
- [ ] Detalhes do pedido (status, itens, pagamento, frete)
- [ ] Rastreamento de envio
- [ ] Download de nota fiscal (PDF)
- [ ] Minhas avaliações
- [ ] Avaliar produtos comprados
- [ ] Meus endereços
- [ ] Dados pessoais
- [ ] Alterar senha

---

## Fase 4: Integrações - Sistemas Abstraídos (3-4 semanas)

### 4.1 Sistema de Frete Abstraído
- [ ] **Criar estrutura abstrata**:
  - Interface `ShippingProviderInterface`
  - Service `ShippingService` com Factory Pattern
  - Config `config/shipping.php`
  - Migrations para `shipping_labels` table

- [ ] **Implementar Melhor Envio (Padrão)**:
  - SDK: `composer require melhor-envio/php-sdk`
  - Driver `MelhorEnvioProvider`
  - Métodos: calcular frete, gerar etiqueta, rastreamento
  - Suporte para: Correios, Jadlog, Azul, Loggi, etc

- [ ] **Implementar Correios Direto (Fallback)**:
  - Driver `CorreiosProvider`
  - Integração com API dos Correios
  - Métodos: PAC, SEDEX

- [ ] **Preparar para outros (futuro)**:
  - Estrutura para Jadlog, Loggi, Kangu, Frenet
  - Documentação de como adicionar novos provedores

- [ ] **Funcionalidades**:
  - Calcular frete em múltiplos provedores simultaneamente
  - Exibir todas as opções no checkout
  - Cliente escolhe transportadora e prazo
  - Geração automática de etiqueta após pagamento
  - Rastreamento unificado
  - Fallback automático se um provedor falhar

### 4.2 Sistema de Pagamento Abstraído
- [ ] **Criar estrutura abstrata**:
  - Interface `PaymentGatewayInterface`
  - Service `PaymentService` com Factory Pattern
  - Config `config/payment.php`
  - Migrations para `payment_transactions` table

- [ ] **Implementar Mercado Pago (Padrão)**:
  - SDK: `composer require mercadopago/dx-php`
  - Driver `MercadoPagoProvider`
  - Métodos de pagamento:
    - Cartão de crédito (parcelamento)
    - PIX (QR Code + Copy&Paste)
    - Boleto
  - Webhooks para notificações
  - Atualização automática de status do pedido

- [ ] **Implementar Stripe**:
  - SDK: `composer require stripe/stripe-php`
  - Driver `StripeProvider`
  - Cartão de crédito (nacional e internacional)
  - Webhooks

- [ ] **Implementar Asaas**:
  - Driver `AsaasProvider`
  - Cartão, PIX, Boleto
  - Taxas mais baixas

- [ ] **Preparar para outros (futuro)**:
  - PagSeguro, Pagar.me, PayPal
  - Estrutura pronta

- [ ] **Funcionalidades**:
  - Cliente vê múltiplos métodos de pagamento
  - Cada gateway oferece seus métodos
  - Processamento unificado
  - Webhooks centralizados
  - Reembolso/estorno

### 4.3 Sistema de Nota Fiscal Abstraído
- [ ] **Criar estrutura abstrata**:
  - Interface `InvoiceProviderInterface`
  - Service `InvoiceService` com Factory Pattern
  - Config `config/invoice.php`
  - Migrations para `invoices` table (XML, PDF, status)

- [ ] **Implementar Focus NFe (Padrão)**:
  - SDK: `composer require focusnfe/focusnfe-api-client`
  - Driver `FocusNFeProvider`
  - Emissão de NFe/NFCe
  - Cancelamento
  - Download XML/PDF (DANFE)

- [ ] **Implementar eNotas (Alternativa)**:
  - SDK: `composer require enotasgw/api-client`
  - Driver `ENotasProvider`
  - Mesmas funcionalidades

- [ ] **Preparar para outros (futuro)**:
  - NFe.io, WebMania
  - Estrutura pronta

- [ ] **Funcionalidades**:
  - Emissão automática após confirmação de pagamento
  - Armazenamento de XML e PDF
  - Envio automático por e-mail
  - Download na área do cliente
  - Cancelamento de notas
  - Série e numeração sequencial
  - Contingência (se API cair)

### 4.4 E-mails Transacionais
- [ ] **Templates de e-mails** (Blade + Mailables):
  - Confirmação de pedido (com resumo)
  - Pagamento aprovado
  - Nota fiscal emitida (anexar XML/PDF)
  - Pedido enviado (código de rastreamento + link)
  - Pedido entregue
  - Pedido cancelado
  - Recuperação de senha
  - Boas-vindas (novo cliente)

- [ ] **E-mails marketing** (opcional):
  - Carrinho abandonado (3 e-mails: 1h, 24h, 72h)
  - Produto voltou ao estoque
  - Promoções personalizadas

- [ ] **Configuração**:
  - SMTP via Settings do Filament
  - Suporte para serviços: Gmail, Mailgun, SendGrid, Amazon SES
  - Preview de templates no Filament
  - Variáveis dinâmicas

### 4.5 Webhooks e Eventos
- [ ] **Sistema de Webhooks**:
  - Rota unificada para todos os provedores
  - Validação de assinaturas
  - Log de webhooks recebidos
  - Retry automático em caso de falha

- [ ] **Eventos Laravel**:
  - `OrderCreated`
  - `PaymentConfirmed`
  - `InvoiceIssued`
  - `OrderShipped`
  - `OrderDelivered`
  - Listeners para automações

---

## Fase 5: Sistema de Personalização e Themes (2-3 semanas)

### 5.1 Sistema de Themes (5 Designs)
- [ ] **Implementação dos 5 temas**:
  - Criar layouts base para cada tema
  - Adaptar todos os componentes para funcionar em todos os temas
  - Sistema de herança: tema base + customizações
  - Responsive design para todos os temas

- [ ] **Theme Switcher**:
  - Service para detectar tema ativo
  - Middleware para carregar o tema correto
  - View Composer para variáveis do tema
  - Cache de tema para performance

- [ ] **Preview de Temas**:
  - Screenshots de cada tema
  - Preview ao vivo no Filament (iframe)
  - Comparação lado a lado

### 5.2 Gestão de Banners Responsivos
- [ ] **Banner Manager Service**:
  - Upload separado para web e mobile
  - Crop/resize automático
  - Validação de dimensões recomendadas
  - Sistema de fallback (se não houver mobile, usa web)

- [ ] **Exibição Dinâmica**:
  - Componente Livewire para banners
  - Carrossel responsivo (Swiper.js ou similar)
  - Lazy loading de imagens
  - Suporte a webp para performance
  - Ordenação via drag & drop no Filament

- [ ] **Posicionamento de Banners**:
  - Homepage hero
  - Homepage banners secundários
  - Páginas de categoria
  - Páginas de produto (banner lateral)
  - Banner de promoção (topo/rodapé)

### 5.3 Customização Visual Dinâmica
- [ ] Service para aplicar customizações:
  - Cores CSS (Tailwind CSS variables) por tema
  - Logo (header, footer, favicon)
  - Fontes (Google Fonts)
  - Espaçamentos e bordas
- [ ] Preview em tempo real no Filament
- [ ] Cache de configurações para performance

### 5.4 Gestão de Assets
- [ ] Upload de logo via Filament
- [ ] Upload de imagens para banners (web/mobile)
- [ ] Gestão de favicon
- [ ] Otimização automática de imagens
- [ ] Conversão para webp automática

---

## Fase 6: SEO e Performance (1 semana)

### 6.1 SEO
- [ ] URLs amigáveis (slugs)
- [ ] Meta tags dinâmicas
- [ ] Sitemap.xml automático
- [ ] Robots.txt
- [ ] Schema.org markup (produtos)
- [ ] Open Graph para redes sociais

### 6.2 Performance
- [ ] Cache de queries (Redis - opcional)
- [ ] Lazy loading de imagens
- [ ] Otimização de assets (Vite)
- [ ] CDN para imagens (opcional)

---

## Fase 7: Testes e Refinamentos (1-2 semanas)

### 7.1 Testes
- [ ] Testes Feature (Pest):
  - Fluxo completo de compra
  - Cálculo de frete
  - Aplicação de cupons
  - Pagamentos
- [ ] Testes Unit para Services
- [ ] Testes de integração

### 7.2 Documentação
- [ ] Documentação de instalação
- [ ] Guia de personalização
- [ ] Documentação de API (se necessário)
- [ ] Manual do administrador

---

## Ordem Recomendada de Implementação

### Sprint 1-2 (Semanas 1-2): Fundação
1. Criar todas as migrations
2. Criar models e relationships
3. Seeders com dados de teste
4. Configuração básica do sistema de Settings

### Sprint 3-4 (Semanas 3-4): Admin - Produtos
1. Product Resource completo
2. Category Resource
3. Upload de imagens
4. Gestão de variações e estoque

### Sprint 5-6 (Semanas 5-6): Admin - Pedidos, Clientes e Banners
1. Order Resource
2. Customer Resource
3. Coupon Resource
4. **Banner Resource** (gestão web/mobile)
5. **Review Resource** (avaliações)
6. Dashboard widgets

### Sprint 7-8 (Semanas 7-8): Admin - CMS e Configurações
1. **Page Resource** (CMS para páginas institucionais)
2. **Theme Manager no Filament**
3. **Settings completo** (todas as abas: geral, fiscal, frete, pagamento, NFe)
4. Preview de temas

### Sprint 9-11 (Semanas 9-11): Frontend - Estrutura de Themes
1. Criar estrutura de diretórios para os 5 temas
2. **Implementar Tema 1 (Modern)** - completo
3. Sistema de detecção de tema ativo
4. Componente de banners responsivos
5. Sistema de avaliações no frontend

### Sprint 12-14 (Semanas 12-14): Frontend - Implementar Outros Themes
1. **Tema 2 (Classic)** - adaptar do Modern
2. **Tema 3 (Bold)** - adaptar do Modern
3. **Tema 4 (Minimal)** - adaptar do Modern
4. **Tema 5 (Elegant)** - adaptar do Modern
5. Testar todos os temas em diferentes dispositivos

### Sprint 15-16 (Semanas 15-16): Frontend - Carrinho e Checkout
1. Carrinho de compras (funciona em todos os temas)
2. Fluxo de checkout multi-step
3. Autenticação de cliente
4. Área do cliente (com download de NFe)

### Sprint 17-20 (Semanas 17-20): Integrações - Sistemas Abstraídos
**Sprint 17: Frete**
1. Estrutura abstrata de frete
2. Melhor Envio (driver completo)
3. Correios Direto (fallback)
4. Integração com checkout

**Sprint 18: Pagamento**
1. Estrutura abstrata de pagamento
2. Mercado Pago (PIX, Cartão, Boleto)
3. Stripe (Cartão)
4. Asaas (opções completas)
5. Webhooks centralizados

**Sprint 19: Nota Fiscal**
1. Estrutura abstrata de NFe
2. Focus NFe (driver completo)
3. eNotas (alternativa)
4. Emissão automática
5. E-mails com anexos

**Sprint 20: E-mails e Eventos**
1. Templates de e-mails transacionais
2. Sistema de eventos Laravel
3. Webhooks unificados
4. Testes de integração

### Sprint 21-22 (Semanas 21-22): Personalização Final e Polimento
1. Sistema de customização visual por tema
2. Otimização de banners (webp, lazy loading)
3. Relatórios avançados
4. SEO completo
5. Performance e cache
6. Testes finais em todos os temas
7. Correções e ajustes

---

## Tecnologias e Pacotes Recomendados

### Laravel Packages
```bash
# Já instalados
- filament/filament
- livewire/flux
- livewire/volt

# === INTEGRAÇÕES - SISTEMAS ABSTRAÍDOS ===

# Frete
composer require melhor-envio/php-sdk           # Melhor Envio (padrão)
# Correios: API direta (sem SDK oficial)

# Pagamento
composer require mercadopago/dx-php             # Mercado Pago
composer require stripe/stripe-php              # Stripe
# Asaas: API REST (sem SDK oficial)
# PagSeguro: composer require pagseguro/pagseguro-php-sdk (futuro)
# Pagar.me: composer require pagarme/pagarme-php (futuro)

# Nota Fiscal
composer require focusnfe/focusnfe-api-client   # Focus NFe
composer require enotasgw/api-client            # eNotas
# NFe.io e WebMania: APIs REST

# === FUNCIONALIDADES GERAIS ===

# Gestão de mídia (imagens, banners, NFe PDFs)
composer require spatie/laravel-medialibrary
composer require filament/spatie-laravel-media-library-plugin

# SEO e URLs
composer require spatie/laravel-sluggable       # URLs amigáveis
composer require spatie/laravel-sitemap         # Sitemap automático

# Imagens
composer require intervention/image             # Manipulação e otimização

# Exportação de relatórios
composer require maatwebsite/excel              # Excel
composer require barryvdh/laravel-dompdf        # PDF

# Editor WYSIWYG para CMS
composer require filament/forms                 # Já vem com RichEditor
```

### Frontend (já configurado + adicional)
- Tailwind CSS v4
- Alpine.js (via Livewire)
- Vite

### Frontend - Bibliotecas Adicionais para Banners/Carrossel
```bash
npm install swiper                              # Carrossel responsivo
npm install @splidejs/splide                    # Alternativa ao Swiper (opcional)
```

---

## Estimativa de Tempo Total

**Duração:** 21-22 semanas (~5-6 meses)

### Breakdown:
- **Fase 1 (Fundação):** 1-2 semanas
- **Fase 2 (Admin Filament):** 3-4 semanas
- **Fase 3 (Frontend TALL):** 4-5 semanas
- **Fase 4 (Integrações Abstraídas):** 4 semanas ⭐ **Core do projeto**
- **Fase 5 (Themes/Personalização):** 3-4 semanas
- **Fase 6 (SEO/Performance):** 1 semana
- **Fase 7 (Testes/Polimento):** 2 semanas

### Marcos Importantes:
- ✅ **Semana 6:** Admin funcional (produtos, pedidos, clientes)
- ✅ **Semana 14:** Todos os 5 themes implementados
- ✅ **Semana 16:** Checkout funcional
- ✅ **Semana 20:** Todas as integrações (frete, pagamento, NFe) funcionando
- ✅ **Semana 22:** Produto finalizado e testado

---

## Próximos Passos Imediatos

### 🎯 Sprint 1 - Semana 1 (AGORA)

1. **Revisar e aprovar este roadmap**

2. **Instalar pacotes essenciais:**
   ```bash
   composer require spatie/laravel-medialibrary
   composer require spatie/laravel-sluggable
   composer require intervention/image
   composer require filament/spatie-laravel-media-library-plugin
   ```

3. **Criar todas as migrations** (Fase 1.1):
   ```bash
   php artisan make:migration create_products_table
   php artisan make:migration create_categories_table
   php artisan make:migration create_product_images_table
   php artisan make:migration create_product_variants_table
   php artisan make:migration create_inventory_table
   php artisan make:migration create_orders_table
   php artisan make:migration create_order_items_table
   php artisan make:migration create_customers_table
   php artisan make:migration create_addresses_table
   php artisan make:migration create_coupons_table
   php artisan make:migration create_reviews_table
   php artisan make:migration create_payment_transactions_table
   php artisan make:migration create_invoices_table
   php artisan make:migration create_shipping_labels_table
   php artisan make:migration create_pages_table
   php artisan make:migration create_settings_table
   php artisan make:migration create_themes_table
   php artisan make:migration create_banners_table
   ```

4. **Definir schema completo do banco** (ver estruturas abaixo)

5. **Criar estrutura de diretórios:**
   ```bash
   mkdir -p app/Services/Shipping
   mkdir -p app/Services/Payment
   mkdir -p app/Services/Invoice
   mkdir -p resources/views/themes/{base,modern,classic,bold,minimal,elegant}
   ```

6. **Começar Product Resource no Filament:**
   ```bash
   php artisan make:filament-resource Product
   ```

## Estrutura de Themes Proposta

```
resources/views/themes/
├── base/                          # Tema base (componentes compartilhados)
│   ├── layouts/
│   │   ├── app.blade.php         # Layout principal
│   │   ├── header.blade.php
│   │   └── footer.blade.php
│   └── components/
│       ├── product-card.blade.php
│       ├── banner.blade.php
│       └── ...
├── modern/                        # Tema 1: Modern
│   ├── layouts/
│   │   └── app.blade.php         # Override do layout base
│   ├── pages/
│   │   ├── home.blade.php
│   │   ├── category.blade.php
│   │   └── product.blade.php
│   └── components/               # Componentes específicos do tema
├── classic/                       # Tema 2: Classic
├── bold/                          # Tema 3: Bold
├── minimal/                       # Tema 4: Minimal
└── elegant/                       # Tema 5: Elegant
```

## Estrutura de Banners no Banco

```sql
banners:
  - id
  - title
  - description (nullable)
  - image_web (path)
  - image_mobile (path, nullable)
  - link (nullable)
  - cta_text (nullable)
  - position (enum: hero, secondary, category, product, promotion)
  - order (integer)
  - start_date (nullable)
  - end_date (nullable)
  - is_active (boolean)
  - created_at
  - updated_at
```

---

## 🚀 Diferenciais Competitivos do FlexCommerce

Este e-commerce se destaca da concorrência por:

### 1. **Sistemas Abstraídos (Multi-Provedor)** 🔥
- **Frete**: Cliente escolhe entre Melhor Envio, Correios, Jadlog, etc
- **Pagamento**: Suporta Mercado Pago, Stripe, Asaas, PagSeguro simultaneamente
- **NFe**: Focus NFe, eNotas, NFe.io - flexibilidade total
- **Benefício**: Cliente não fica preso a um único fornecedor, pode negociar taxas

### 2. **5 Temas Visuais Completos**
- Modern, Classic, Bold, Minimal, Elegant
- Troca em 1 clique no admin
- Totalmente responsivos
- **Benefício**: Venda para nichos diferentes sem reescrever código

### 3. **CMS Integrado**
- Editor WYSIWYG no Filament
- Páginas institucionais editáveis
- Sem código
- **Benefício**: Cliente edita conteúdo sem precisar de desenvolvedor

### 4. **Gestão de Banners Web/Mobile**
- Upload separado por dispositivo
- Agendamento de exibição
- Drag & drop para ordenar
- **Benefício**: Campanhas profissionais facilmente

### 5. **Sistema de Avaliações**
- Clientes avaliam produtos
- Moderação no admin
- Upload de fotos
- **Benefício**: Social proof aumenta conversão

### 6. **Nota Fiscal Automática**
- Emissão após pagamento confirmado
- Download na área do cliente
- Envio por e-mail
- **Benefício**: Compliance fiscal automático

### 7. **Múltiplas Transportadoras no Checkout**
- Cliente escolhe preço vs velocidade
- Rastreamento unificado
- **Benefício**: Melhor experiência de compra

### 8. **Relatórios Fiscais Completos**
- NCM, CFOP, impostos configuráveis
- Relatórios para contabilidade
- **Benefício**: E-commerce em compliance

### 9. **TALL Stack (Performance)**
- Livewire = SPA sem JavaScript complexo
- Tailwind CSS v4 = CSS otimizado
- **Benefício**: Rápido e fácil de manter

### 10. **Arquitetura Escalável**
- Factory Pattern para provedores
- Fácil adicionar novos gateways/themes
- Bem documentado
- **Benefício**: Evolução contínua

---

## 📊 Comparação com Concorrentes

| Funcionalidade | FlexCommerce | WooCommerce | Shopify | Nuvemshop |
|----------------|--------------|-------------|---------|-----------|
| **Múltiplos gateways de pagamento** | ✅ Abstraído | ⚠️ Plugins | ⚠️ Limitado | ⚠️ Limitado |
| **Múltiplas transportadoras** | ✅ Abstraído | ⚠️ Plugins | ❌ Não | ⚠️ Limitado |
| **Múltiplos provedores de NFe** | ✅ Abstraído | ❌ Não | ❌ Não | ⚠️ 1 provedor |
| **Troca de temas (1 clique)** | ✅ 5 temas | ✅ Sim | ✅ Sim | ⚠️ Limitado |
| **CMS integrado** | ✅ Completo | ⚠️ Básico | ✅ Sim | ⚠️ Básico |
| **Banners web/mobile separados** | ✅ Sim | ❌ Não | ⚠️ Parcial | ❌ Não |
| **Sistema de avaliações** | ✅ Nativo | ⚠️ Plugin | ✅ Nativo | ⚠️ Básico |
| **Relatórios fiscais** | ✅ Completo | ❌ Não | ❌ Não | ⚠️ Básico |
| **Open-source / Personalizável** | ✅ Total | ✅ Sim | ❌ Não | ❌ Não |
| **Custo mensal** | R$ 0 (host) | R$ 0-50 | R$ 150+ | R$ 150+ |

**Legenda:**
- ✅ = Funcionalidade completa
- ⚠️ = Funcionalidade parcial ou através de plugins
- ❌ = Não possui

---

## Observações Importantes

- **Versionamento**: Use Git para controlar versões durante todo o desenvolvimento
- **Ambiente de Testes**: Configure um ambiente staging para testes antes do deploy
- **Segurança**: Implementar validações adequadas, proteção CSRF, sanitização de inputs
- **Backup**: Configure backups automáticos do banco de dados
- **Logs**: Use o Laravel Log para rastrear erros e ações importantes
