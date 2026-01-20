const deletePrompt = (message = 'Möchten Sie diesen Eintrag wirklich löschen?') => {
    return window.confirm(message);
};

document.addEventListener('click', (event) => {
    const link = event.target.closest('a');
    if (!link) {
        return;
    }

    const isDeleteLink = link.href.includes('action=delete');
    if (!isDeleteLink) {
        return;
    }

    if (!deletePrompt()) {
        event.preventDefault();
    }
});
