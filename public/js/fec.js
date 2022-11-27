window.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("fec-form");
    const elDownloadType = document.getElementById("fec-download-type");

    // candidate search
    const elCandidateId = document.getElementById("fec-candidate-id");
    const elCandidateSearch = document.getElementById("fec-candidate-search");
    const candidatesJson = elCandidateSearch.getAttribute("data-candidates");
    const candidatesData = JSON.parse(candidatesJson);

    new Autocomplete(elCandidateSearch, {
        data: candidatesData,
        maximumItems: 5,
        threshold: 1,
        onSelectItem: candidate => {
            elCandidateId.value = candidate.value;
            elDownloadType.value = "";
            form.submit();
        }
    });

    // clear button
    const elClearButton = document.getElementById("fec-clear");
    elClearButton.addEventListener("click", e => {
        elCandidateId.value = "";
        elDownloadType.value = "";
        form.submit();
        e.stopPropagation();
        e.preventDefault();
        return false;
    });

    // total type dropdown
    const elTotalType = document.getElementById("fec-total-type");
    elTotalType.addEventListener("change", () => {
        elDownloadType.value = "";
        form.submit();
    });

    // download links
    const downloadLinks = document.querySelectorAll("a[data-download='1']");

    for (let i = 0; i < downloadLinks.length; i++) {
        const downloadLink = downloadLinks.item(i);
        downloadLink.addEventListener("click", e => {
            elDownloadType.value = downloadLink.getAttribute("data-download-type");
            form.submit();
            e.stopPropagation();
            e.preventDefault();
            return false;
        });
    }
});