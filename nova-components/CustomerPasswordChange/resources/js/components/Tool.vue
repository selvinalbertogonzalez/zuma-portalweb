<template>
  <div>
    <h3>Cambio de contraseña</h3>
    <card class="card mt-3 mb-6 py-3 px-6">
      <div class="flex">
        <div class="w-1/4 py-4">
          <h4 class="font-normal text-80">Nueva contraseña</h4>
        </div>
        <div class="w-3/4 py-4 break-words">
          <input
            v-model="newPassword"
            type="password"
            placeholder="Ingresa la nueva contraseña"
            class="w-full form-control form-input form-input-bordered"
          />
        </div>
      </div>
    </card>
    <button
      @click="updatePassword"
      class="btn btn-default btn-primary inline-flex items-center relative"
      :disabled="isUpdating"
    >Actualizar contraseña</button>
  </div>
</template>

<script>
export default {
  props: ["resourceName", "resourceId", "panel"],
  data() {
    return {
      newPassword: "",
      isUpdating: false
    };
  },
  methods: {
    updatePassword() {
      if (this.newPassword.length > 5) {
        this.isUpdating = true;
        axios
          .post("/zuma/customer-password-change", {
            id: this.resourceId,
            password: this.newPassword
          })
          .then(({ data }) => {
            if (data.message == "updated_successfully") {
              this.$toasted.show("Contraseña actualizada exitosamente.", {
                type: "success"
              });
            } else {
              this.$toasted.show("Error al actualizar la contraseña.", {
                type: "error"
              });
            }
          })
          .catch(error => {
            this.$toasted.show(
              "No se pudo actualizar la contraseña, intenta más tarde.",
              {
                type: "error"
              }
            );
          })
          .finally(() => {
            this.isUpdating = false;
            this.newPassword = "";
          });
      } else {
        this.$toasted.show(
          "La contraseña debe contener al menos 6 caracteres.",
          {
            type: "error"
          }
        );
      }
    }
  }
};
</script>
