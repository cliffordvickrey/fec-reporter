window.addEventListener("DOMContentLoaded", () => {
    const reportForm = document.getElementById("fec-form");
    const downloadForm = document.getElementById("fec-download-form");

    // autocompletes
    const autocompletes = document.querySelectorAll("input[data-autocomplete='1']");

    for (let i = 0; i < autocompletes.length; i++) {
        const autocomplete = autocompletes.item(i);

        new Autocomplete(autocomplete, {
            data: JSON.parse(autocomplete.getAttribute("data-payload")),
            maximumItems: 5,
            threshold: 1,
            onSelectItem: selected => {
                const boundTo = autocomplete.getAttribute("data-bound-to");
                document.getElementById(boundTo).value = selected.value;
                reportForm.action = "#" + encodeURIComponent(boundTo) + "-search";
                reportForm.submit();
            }
        });
    }

    // clear buttons
    const clearButtons = document.querySelectorAll("button[data-clear='1']");

    for (let i = 0; i < clearButtons.length; i++) {
        const clearButton = clearButtons.item(i);

        clearButton.addEventListener("click", e => {
            const boundTo = clearButton.getAttribute("data-bound-to");
            document.getElementById(boundTo).value = "";
            reportForm.submit();
            e.stopPropagation();
            e.preventDefault();
            return false;
        });
    }

    // dropdowns
    const dropdowns = document.querySelectorAll("select[data-dropdown='1']");

    for (let i = 0; i < dropdowns.length; i++) {
        const dropdown = dropdowns.item(i);
        dropdown.addEventListener("change", () => {
            reportForm.action = "#" + encodeURIComponent(dropdown.id);
            reportForm.submit()
        });
    }

    // download links
    const downloadLinks = document.querySelectorAll("a[data-download='1']");

    for (let i = 0; i < downloadLinks.length; i++) {
        const downloadLink = downloadLinks.item(i);
        downloadLink.addEventListener("click", e => {
            document.getElementById("fec-download-type").value = downloadLink.getAttribute("data-download-type");
            downloadForm.submit();
            e.stopPropagation();
            e.preventDefault();
            return false;
        });
    }
});