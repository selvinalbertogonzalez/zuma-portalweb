<template>
  <div>
    <div
      v-if="isLoading"
      class="flex items-center justify-center z-50 p-6"
      style="min-height: 150px;"
    >
      <svg
        viewBox="0 0 120 30"
        xmlns="http://www.w3.org/2000/svg"
        fill="currentColor"
        class="text-60 mx-auto block"
        style="width: 50px;"
      >
        <circle cx="15" cy="15" r="12.5015">
          <animate
            attributeName="r"
            from="15"
            to="15"
            begin="0s"
            dur="0.8s"
            values="15;9;15"
            calcMode="linear"
            repeatCount="indefinite"
          />
          <animate
            attributeName="fill-opacity"
            from="1"
            to="1"
            begin="0s"
            dur="0.8s"
            values="1;.5;1"
            calcMode="linear"
            repeatCount="indefinite"
          />
        </circle>
        <circle cx="60" cy="15" r="11.4985" fill-opacity="0.3">
          <animate
            attributeName="r"
            from="9"
            to="9"
            begin="0s"
            dur="0.8s"
            values="9;15;9"
            calcMode="linear"
            repeatCount="indefinite"
          />
          <animate
            attributeName="fill-opacity"
            from="0.5"
            to="0.5"
            begin="0s"
            dur="0.8s"
            values=".5;1;.5"
            calcMode="linear"
            repeatCount="indefinite"
          />
        </circle>
        <circle cx="105" cy="15" r="12.5015">
          <animate
            attributeName="r"
            from="15"
            to="15"
            begin="0s"
            dur="0.8s"
            values="15;9;15"
            calcMode="linear"
            repeatCount="indefinite"
          />
          <animate
            attributeName="fill-opacity"
            from="1"
            to="1"
            begin="0s"
            dur="0.8s"
            values="1;.5;1"
            calcMode="linear"
            repeatCount="indefinite"
          />
        </circle>
      </svg>
    </div>
    <div v-else>
      <h3>Configuración del POS</h3>
      <card class="card mt-3 mb-6 py-3 px-6">
        
        <div class="flex border-b border-40">
          <div class="w-1/4 py-4">
            <h4 class="font-normal text-80">Propina Cerrada</h4>
          </div>
          <div class="w-3/4 py-4 break-words">
            <input class="form-check-input" type="checkbox" v-model="closedTip" />
          </div>
        </div>
        <div class="flex border-b border-40">
          <div class="w-1/4 py-4">
            <h4 class="font-normal text-80">Cuotas</h4>
          </div>
          <div class="w-3/4 py-4 break-words">
            <input class="form-check-input" type="checkbox" v-model="hasPayments" />
          </div>
        </div>
        <div v-if="hasPayments" class="flex border-b border-40" resource-id="11">
          <div class="w-1/5 px-8 py-6">
            <label for="user" class="inline-block text-80 pt-2 leading-tight">Cuotas Disponibles</label>
          </div>
          <div class="py-6 px-8 w-1/2">
            <input
              v-model="payments"
              placeholder="Cuotas disponibles"
              class="w-full form-control form-input form-input-bordered"
            />
            <div
              class="help-text help-text mt-2"
            >Ingrese las cuotas válidas sin espacios en formato de 2 dígitos, ej. 030612.</div>
          </div>
        </div>
        <div class="flex border-b border-40">
          <div class="w-1/4 py-4">
            <h4 class="font-normal text-80">Solicitar firma</h4>
          </div>
          <div class="w-3/4 py-4 break-words">
            <input class="form-check-input" type="checkbox" v-model="hasSignature" />
          </div>
        </div>
        <div v-if="hasSignature" class="flex border-b border-40" resource-id="11">
          <div class="w-1/5 px-8 py-6">
            <label
              for="user"
              class="inline-block text-80 pt-2 leading-tight"
            >Monto mínimo para firma</label>
          </div>
          <div class="py-6 px-8 w-1/2">
            <input
              v-model="signatureMinAmount"
              placeholder="Cuotas disponibles"
              class="w-full form-control form-input form-input-bordered"
            />
            <div
              class="help-text help-text mt-2"
            >A partir del monto seleccionado, se solicitará firma al usuario.</div>
          </div>
        </div>
        <div class="flex border-b border-40" resource-id="11">
          <div class="w-1/5 px-8 py-6">
            <label for="user" class="inline-block text-80 pt-2 leading-tight">Pin de POS</label>
          </div>
          <div class="py-6 px-8 w-1/2">
            <input
              v-model="posPin"
              placeholder="PIN Pos"
              class="w-full form-control form-input form-input-bordered"
            />
            <div class="help-text help-text mt-2">PIN para realizar la conexión hacia el POS.</div>
          </div>
        </div>
      </card>
      <button
        @click="updateParameters"
        class="btn btn-default btn-primary inline-flex items-center relative"
        :disabled="isUpdating"
      >Actualizar parámetros</button>
    </div>
  </div>
</template>

<script>
export default {
  props: ["resourceName", "resourceId", "panel"],
  data() {
    return {
      hasPayments: false,
      payments: "",
      closedTip: false,
      openTip: false,
      automaticClosure: false,
      isLoading: false,
      hasSignature: false,
      signatureMinAmount: 0,
      isUpdating: false,
      posPin: ""
    };
  },
  mounted() {
    this.isLoading = true;
    axios.get("/zuma/pos-config/" + this.resourceId).then(({ data }) => {
      this.isLoading = false;
      this.openTip = false//data.open_tip == 1;
      this.closedTip = data.closed_tip == 1;
      this.automaticClosure = data.automatic_closure == 1;
      this.hasPayments = true;
      // console.log(data.payments)
      this.payments = data.payments;
      this.posPin = data.pos_pin;
      // this.hasPayments = data.payments.length > 0;
      this.signatureMinAmount =
        data.signature_amount == 100000000000 ? 0 : data.signature_amount;
      this.hasSignature = data.signature_amount != 100000000000;
    });
  },
  methods: {
    updateParameters() {
      this.isUpdating = true;
      let requestData = {
        open_tip: this.openTip,
        pos_pin: this.posPin,
        closed_tip: this.closedTip,
        automatic_closure: this.automaticClosure,
        payments: this.payments,
        signature_amount: this.hasSignature
          ? this.signatureMinAmount
          : 100000000000
      };
      axios
        .post("/zuma/pos-config/" + this.resourceId, requestData)
        .then(({ data }) => {
          this.isUpdating = false;
          switch (data.message) {
            case "configured_successfully":
              this.$toasted.show("Parámetros actualizados exitosamente.", {
                type: "success"
              });
              break;
            default:
              this.$toasted.show(
                "No se pudieron actualizar los parámetros, intenta más tarde.",
                {
                  type: "error"
                }
              );
              break;
          }
        })
        .catch(() => {
          this.$toasted.show(
            "Ocurrió un error con su conexión, intenta más tarde.",
            {
              type: "error"
            }
          );
          this.isUpdating = false;
        });
    }
  }
};
</script>
