/**
 * Touche Pas au Klaxon - JavaScript
 *
 * Bootstrap gère automatiquement les modales.
 * Ce fichier ajoute :
 * - la disparition automatique du message flash ;
 * - une validation simple des formulaires de trajet côté client.
 */

document.addEventListener('DOMContentLoaded', () => {
    initFlashMessage();
    initTrajetValidation();
});

/**
 * Fait disparaître le message flash après quelques secondes.
 *
 * @returns {void}
 */
function initFlashMessage() {
    const flash = document.querySelector('.flash-message');

    if (!flash) {
        return;
    }

    setTimeout(() => {
        flash.style.transition = 'opacity 0.5s ease';
        flash.style.opacity = '0';

        setTimeout(() => {
            flash.remove();
        }, 500);
    }, 4000);
}

/**
 * Active la validation côté client sur les formulaires de création
 * et de modification de trajet.
 *
 * @returns {void}
 */
function initTrajetValidation() {
    const forms = document.querySelectorAll(
    'form[action*="/trajets/store"], form[action*="/trajets/update/"]'
);

    forms.forEach((form) => {
        form.addEventListener('submit', (event) => {
            clearValidation(form);

            const errors = validateTrajetForm(form);

            if (errors.length > 0) {
                event.preventDefault();
                showErrors(form, errors);

                const firstInvalid = form.querySelector('.is-invalid');
                if (firstInvalid && typeof firstInvalid.focus === 'function') {
                    firstInvalid.focus();
                }
            }
        });
    });
}

/**
 * Vérifie les règles de cohérence du formulaire trajet.
 *
 * @param {HTMLFormElement} form
 * @returns {string[]}
 */
function validateTrajetForm(form) {
    const errors = [];

    const agenceDepart = form.querySelector('[name="id_agence_depart"]');
    const agenceArrivee = form.querySelector('[name="id_agence_arrivee"]');
    const dateDepart = form.querySelector('[name="date_depart"]');
    const heureDepart = form.querySelector('[name="heure_depart"]');
    const dateArrivee = form.querySelector('[name="date_arrivee"]');
    const heureArrivee = form.querySelector('[name="heure_arrivee"]');
    const placesTotales = form.querySelector('[name="places_totales"]');
    const placesDisponibles = form.querySelector('[name="places_disponibles"]');

    if (agenceDepart && agenceArrivee && agenceDepart.value && agenceArrivee.value) {
        if (agenceDepart.value === agenceArrivee.value) {
            errors.push("L'agence de départ et l'agence d'arrivée doivent être différentes.");
            markInvalid(agenceDepart);
            markInvalid(agenceArrivee);
        }
    }

    if (dateDepart && heureDepart && dateArrivee && heureArrivee) {
        if (dateDepart.value && heureDepart.value && dateArrivee.value && heureArrivee.value) {
            const depart = new Date(`${dateDepart.value}T${heureDepart.value}`);
            const arrivee = new Date(`${dateArrivee.value}T${heureArrivee.value}`);

            if (arrivee <= depart) {
                errors.push("La date et l'heure d'arrivée doivent être postérieures au départ.");
                markInvalid(dateDepart);
                markInvalid(heureDepart);
                markInvalid(dateArrivee);
                markInvalid(heureArrivee);
            }
        }
    }

    if (placesTotales && placesDisponibles) {
        const total = parseInt(placesTotales.value, 10);
        const disponibles = parseInt(placesDisponibles.value, 10);

        if (!Number.isNaN(total) && total < 1) {
            errors.push("Le nombre de places totales doit être au minimum de 1.");
            markInvalid(placesTotales);
        }

        if (!Number.isNaN(disponibles) && disponibles < 0) {
            errors.push("Le nombre de places disponibles ne peut pas être négatif.");
            markInvalid(placesDisponibles);
        }

        if (
            !Number.isNaN(total) &&
            !Number.isNaN(disponibles) &&
            disponibles > total
        ) {
            errors.push("Le nombre de places disponibles ne peut pas dépasser le nombre de places totales.");
            markInvalid(placesTotales);
            markInvalid(placesDisponibles);
        }
    }

    return errors;
}

/**
 * Affiche les erreurs en haut du formulaire.
 *
 * @param {HTMLFormElement} form
 * @param {string[]} errors
 * @returns {void}
 */
function showErrors(form, errors) {
    const alert = document.createElement('div');
    alert.className = 'alert alert-danger';
    alert.setAttribute('role', 'alert');

    const list = document.createElement('ul');
    list.className = 'mb-0';

    errors.forEach((error) => {
        const item = document.createElement('li');
        item.textContent = error;
        list.appendChild(item);
    });

    alert.appendChild(list);
    form.prepend(alert);
}

/**
 * Supprime les anciennes erreurs visuelles du formulaire.
 *
 * @param {HTMLFormElement} form
 * @returns {void}
 */
function clearValidation(form) {
    const alert = form.querySelector('.alert.alert-danger');

    if (alert) {
        alert.remove();
    }

    form.querySelectorAll('.is-invalid').forEach((field) => {
        field.classList.remove('is-invalid');
    });
}

/**
 * Marque un champ comme invalide.
 *
 * @param {HTMLElement} field
 * @returns {void}
 */
function markInvalid(field) {
    field.classList.add('is-invalid');
}