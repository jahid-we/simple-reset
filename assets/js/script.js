document.addEventListener("DOMContentLoaded", function () {
  const modal = document.getElementById("sr-modal");
  const input = document.getElementById("sr-confirm-input");
  const confirm = document.getElementById("sr-modal-confirm");
  const cancel = document.getElementById("sr-modal-cancel");

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

      confirm.disabled = true;

      input.focus();
    });
  });

  input.addEventListener("input", function () {
    confirm.disabled = input.value !== "DELETE";
  });

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

    currentForm.submit();
  });
});
