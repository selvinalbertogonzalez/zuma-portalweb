<template>
  <div>
    <heading class="mb-6">Configuración VISA</heading>

    <card class="flex flex-col">
      <div class="flex border-b border-40" resource-id="11">
        <div class="w-1/5 px-8 py-6">
          <label for="email" class="inline-block text-80 pt-2 leading-tight">
            Correo electrónico
            <span class="text-danger text-sm">*</span>
          </label>
        </div>
        <div class="py-6 px-8 w-1/2">
          <input
            type="email"
            v-model="email"
            placeholder="Correo electrónico"
            class="w-full form-control form-input form-input-bordered"
          />
          <div
            class="help-text help-text mt-2"
          >Correo electrónico de la persona asociada a ZUMA que cuenta con un número de afiliación a VISA.</div>
        </div>
      </div>
      <div class="flex border-b border-40" resource-id="11">
        <div class="w-1/5 px-8 py-6">
          <label for="afiliation" class="inline-block text-80 pt-2 leading-tight">
            Número de afiliación
            <span class="text-danger text-sm">*</span>
          </label>
        </div>
        <div class="py-6 px-8 w-1/2">
          <input
            type="text"
            v-model="affiliation"
            placeholder="Número de afiliación"
            class="w-full form-control form-input form-input-bordered"
          />
          <div
            class="help-text help-text mt-2"
          >Número de afiliación de VISA del usuario que solicita POS.</div>
        </div>
      </div>
      <div class="flex border-b border-40" resource-id="11">
        <div class="w-1/5 px-8 py-6">
          <label for="serial" class="inline-block text-80 pt-2 leading-tight">
            Número de serie
            <span class="text-danger text-sm">*</span>
          </label>
        </div>
        <div class="py-6 px-8 w-1/2">
          <input
            v-model="serial"
            placeholder="Número de serie"
            class="w-full form-control form-input form-input-bordered"
          />
          <div class="help-text help-text mt-2">Número de serie del POS a enviarle al usuario.</div>
        </div>
      </div>
      <div class="flex border-b border-40" resource-id="11">
        <div class="w-1/5 px-8 py-6">
          <label for="user" class="inline-block text-80 pt-2 leading-tight">
            Usuario de afiliación
            <span class="text-danger text-sm">*</span>
          </label>
        </div>
        <div class="py-6 px-8 w-1/2">
          <input
            v-model="user"
            placeholder="Usuario de afiliación"
            class="w-full form-control form-input form-input-bordered"
          />
          <div class="help-text help-text mt-2">Usuario de la afiliación de VISA.</div>
        </div>
      </div>
      <div class="flex border-b border-40" resource-id="11">
        <div class="w-1/5 px-8 py-6">
          <label for="password" class="inline-block text-80 pt-2 leading-tight">
            Contraseña de afiliación
            <span class="text-danger text-sm">*</span>
          </label>
        </div>
        <div class="py-6 px-8 w-1/2">
          <input
            v-model="password"
            placeholder="Contraseña de afiliación"
            class="w-full form-control form-input form-input-bordered"
          />
          <div class="help-text help-text mt-2">Contraseña de la afiliación de VISA.</div>
        </div>
      </div>
    </card>
    <div class="flex items-center mt-2">
      <button
        @click="generateCredentials"
        class="btn btn-default btn-primary inline-flex items-center relative"
        :disabled="isLoading"
      >
        <span class>Generar credenciales</span>
      </button>
    </div>
  </div>
</template>

<script>
export default {
  mounted() {
    var email = location.search.split("email=")[1];

    if (email != undefined) {
      this.email = decodeURIComponent(email);
    }
  },
  data() {
    return {
      email: "",
      serial: "",
      affiliation: "",
      user: "",
      password: "",
      isLoading: false
    };
  },
  methods: {
    generateCredentials() {
      this.isLoading = true;
      if (
        this.email == "" ||
        this.serial == "" ||
        this.affiliation == "" ||
        this.user == "" ||
        this.password == ""
      ) {
        this.$toasted.show("Debe completar todos los campos.", {
          type: "error"
        });
        return;
      }
      axios
        .post("/zuma/visa-config/generate-credentials", {
          email: this.email,
          serial: this.serial,
          affiliation: this.affiliation,
          password: this.password
        })
        .then(({ data }) => {
          switch (data.message) {
            case "email_not_found":
              this.$toasted.show("El usuario indicado no existe.", {
                type: "error"
              });
              break;
            case "already_registered":
              this.$toasted.show(
                "El usuario ingresado ya tiene credenciales.",
                {
                  type: "error"
                }
              );
              break;
            case "invalid_credentials":
              this.$toasted.show("Las credenciales son inválidas.", {
                type: "error"
              });
              break;
            case "registered_successfully":
              this.$toasted.show(
                "Las credenciales se generaron exitosamente.",
                {
                  type: "success"
                }
              );
              break;
            default:
              this.$toasted.show(
                "Ocurrió un error inesperado, intenta más tarde.",
                {
                  type: "error"
                }
              );
              break;
          }
          this.isLoading = false;
        })
        .catch(() => {
          this.$toasted.show(
            "Ocurrió un error con su conexión, intenta más tarde.",
            {
              type: "error"
            }
          );
          this.isLoading = false;
        });
    }
  }
};
</script>

<style>
/* Scoped Styles */
</style>
