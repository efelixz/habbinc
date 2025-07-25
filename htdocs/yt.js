// Ao invés de acesso direto:
// element.addEventListener('click', function() {

// Use verificação segura:
if (element && element.addEventListener) {
    element.addEventListener('click', function() {
        // ... código existente ...
    });
}