document.addEventListener('DOMContentLoaded', () => {
    const productCards = document.querySelectorAll(
        'body.page-wheels .flex-product .card, ' +
        'body.page-tires .flex-product .card, ' +
        'body.page-offroad .flex-product .card, ' +
        'body.page-merchandises .flex-product .card'
    );

    if (!productCards.length) {
        return;
    }

    const dialog = document.createElement('dialog');
    dialog.className = 'product-details-dialog';
    dialog.setAttribute('aria-label', 'Product details');
    dialog.innerHTML = `
        <button class="product-details-close" type="button" aria-label="Close product details">×</button>
        <div class="product-details-layout">
            <img class="product-details-image" alt="">
            <div class="product-details-content"></div>
        </div>
    `;
    document.body.appendChild(dialog);

    const detailsContent = dialog.querySelector('.product-details-content');
    const dialogImage = dialog.querySelector('.product-details-image');
    let activeCard = null;
    let activeDetails = null;

    function closeDetails() {
        if (dialog.open) {
            dialog.close();
        }
    }

    dialog.querySelector('.product-details-close').addEventListener('click', closeDetails);
    dialog.addEventListener('click', event => {
        if (event.target === dialog) {
            closeDetails();
        }
    });
    dialog.addEventListener('close', () => {
        if (activeCard && activeDetails) {
            activeCard.appendChild(activeDetails);
        }
        activeCard = null;
        activeDetails = null;
        detailsContent.replaceChildren();
    });

    productCards.forEach(card => {
        const image = card.querySelector(':scope > img') || card.querySelector('img');
        const details = card.querySelector('.card-container, .container');
        const title = details && details.querySelector('h2');
        const price = details && details.querySelector('h3');

        if (!image || !details || !title || !price) {
            return;
        }

        card.classList.add('catalog-product');
        details.classList.add('catalog-product-details');

        const imageButton = document.createElement('button');
        imageButton.type = 'button';
        imageButton.className = 'catalog-image-trigger';
        imageButton.setAttribute('aria-label', `View ${title.textContent.trim()} details`);
        image.parentNode.insertBefore(imageButton, image);
        imageButton.appendChild(image);

        const listingTitle = title.cloneNode(true);
        listingTitle.className = 'catalog-product-name';
        listingTitle.removeAttribute('id');
        const listingPrice = price.cloneNode(true);
        listingPrice.className = 'catalog-product-price';
        listingPrice.removeAttribute('id');
        card.append(listingTitle, listingPrice);

        imageButton.addEventListener('click', () => {
            if (dialog.open) {
                closeDetails();
            }
            activeCard = card;
            activeDetails = details;
            dialogImage.src = image.currentSrc || image.src;
            dialogImage.alt = image.alt || title.textContent.trim();
            detailsContent.appendChild(details);
            dialog.showModal();
        });
    });
});
