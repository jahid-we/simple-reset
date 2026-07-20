document.addEventListener("DOMContentLoaded", function () {
  const modal = document.getElementById("sr-modal");
  const input = document.getElementById("sr-confirm-input");
  const confirm = document.getElementById("sr-modal-confirm");
  const cancel = document.getElementById("sr-modal-cancel");
  const backupConfirmation = document.getElementById("sr-backup-confirmation");

  if (!modal || !input || !confirm || !cancel) {
    return;
  }

  let currentForm = null;
  let triggerName = null;
  let triggerValue = null;

  document.querySelectorAll(".sr-delete-trigger").forEach(function (button) {
    button.addEventListener("click", function (e) {
      e.preventDefault();

      currentForm = this.closest("form");

      // Save the submit button's name & value so we can re-send them via
      // a hidden input when the modal confirms. Calling form.submit()
      // programmatically does NOT include the clicked button in POST data,
      // so PHP's isset($_POST[$action]) check would fail without this.
      triggerName  = this.name;
      triggerValue = this.value;

      modal.classList.add("active");

      input.value = "";

      if (backupConfirmation) {
        backupConfirmation.checked = false;
      }

      updateConfirmButton();

      input.focus();
    });
  });

  function updateConfirmButton() {
    const backupConfirmed = !backupConfirmation || backupConfirmation.checked;
    confirm.disabled = input.value !== "DELETE" || !backupConfirmed;
  }

  input.addEventListener("input", updateConfirmButton);

  if (backupConfirmation) {
    backupConfirmation.addEventListener("change", updateConfirmButton);
  }

  cancel.addEventListener("click", function () {
    modal.classList.remove("active");
    currentForm   = null;
    triggerName   = null;
    triggerValue  = null;
  });

  confirm.addEventListener("click", function () {
    if (!currentForm) return;

    modal.classList.remove("active");

    // Inject a hidden input carrying the submit button's name/value so PHP
    // receives it in $_POST exactly as if the button had been clicked normally.
    if (triggerName) {
      const hidden = document.createElement("input");
      hidden.type  = "hidden";
      hidden.name  = triggerName;
      hidden.value = triggerValue || "1";
      currentForm.appendChild(hidden);
    }

    if (backupConfirmation && backupConfirmation.checked) {
      const backupHidden = document.createElement("input");
      backupHidden.type = "hidden";
      backupHidden.name = "sr_backup_confirmed";
      backupHidden.value = "1";
      currentForm.appendChild(backupHidden);
    }

    currentForm.submit();
  });
});
