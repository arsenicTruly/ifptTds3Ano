# Manual de Uso — Form Builder

## O que é

Form Builder é um framework simples para criar formulários HTML diretamente no navegador, sem escrever código. O usuário configura os campos visualmente e clica em **Concluir** para ver o resultado em tempo real.

---

## Arquivos

| Arquivo | Função |
|---|---|
| `index.html` | Estrutura da página e campo inicial |
| `script.js` | Toda a lógica de criação e visualização |

---

## Como usar

### 1. Abrir a página

Abra o arquivo `index.html` em qualquer navegador moderno. Nenhuma instalação ou servidor é necessário.

---

### 2. Configurar o campo inicial

A página já carrega com um campo pronto para configurar:

- **Rótulo** — digite o nome que aparecerá como label no formulário final (ex: `Nome`, `E-mail`, `Mensagem`).
- **Tipo** — escolha o tipo do campo no menu suspenso.

---

### 3. Tipos de campo disponíveis

| Tipo | Elemento gerado | Quando usar |
|---|---|---|
| Texto | `<input type="text">` | Respostas curtas em texto livre |
| Número | `<input type="number">` | Valores numéricos |
| Data | `<input type="date">` | Seleção de datas com calendário |
| Opções | `<select>` | Lista suspensa com opções predefinidas |
| Textarea | `<textarea>` | Respostas longas ou comentários |

---

### 4. Usando o tipo Opções (Select)

Ao selecionar **Opções** no menu de tipo, um campo extra aparece logo abaixo:

```
Opções (separadas por vírgula): [________________________]
```

Digite as opções desejadas separadas por vírgula:

```
Exemplos válidos:
  Sim,Não
  Manhã, Tarde, Noite
  Brasil,Argentina,Uruguai
```

Cada item se tornará uma `<option>` dentro do `<select>` no formulário final. Se o campo for deixado em branco, será gerada uma opção padrão chamada `opção 1`.

---

### 5. Adicionar mais campos

Clique no botão **Novo campo** para adicionar quantos campos quiser. Cada novo campo aparece abaixo do anterior e segue o mesmo padrão: Rótulo + Tipo.

---

### 6. Visualizar o formulário

Clique em **Concluir** para gerar o formulário. Ele será exibido no painel `<iframe>` logo abaixo dos botões, com todos os campos configurados, prontos para interação.

> **Atenção:** clicar em Concluir sempre regenera o preview com o estado atual dos campos. Alterações feitas depois podem ser visualizadas clicando novamente.

---

## Exemplo passo a passo

**Objetivo:** criar um formulário de contato com Nome, E-mail, Assunto (opções) e Mensagem.

1. No campo inicial, preencha:
   - Rótulo: `Nome`
   - Tipo: `Texto`

2. Clique em **Novo campo**:
   - Rótulo: `E-mail`
   - Tipo: `Texto`

3. Clique em **Novo campo**:
   - Rótulo: `Assunto`
   - Tipo: `Opções`
   - No campo extra que aparece, digite: `Dúvida,Sugestão,Reclamação`

4. Clique em **Novo campo**:
   - Rótulo: `Mensagem`
   - Tipo: `Textarea`

5. Clique em **Concluir**.

O formulário gerado terá exatamente esses quatro campos com seus respectivos tipos.

---

## Limitações

- Os campos são criados apenas na sessão atual — ao recarregar a página, o formulário é resetado.
- O formulário exibido no iframe é apenas uma visualização; ele não envia dados para nenhum servidor.
- Não é possível reordenar campos após criá-los.