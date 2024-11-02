<x-guest-layout>
    <div class="max-w-md mx-auto bg-white shadow-md rounded-lg p-8 mt-10">
        <h2 class="text-2xl font-semibold text-center text-gray-800 mb-6">Autenticación de Dos Factores</h2>

        <!-- Mensaje de error si el código es incorrecto -->
        @if(session('error'))
            <div class="mb-4 text-red-600">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('2fa.verify') }}" id="twoFactorForm">
            @csrf
            <!-- Campo de código de verificación -->
            <div class="mb-4">
                <x-input-label for="two_factor_code" :value="__('Código de verificación')" />
                <x-text-input id="two_factor_code" class="block mt-1 w-full" type="text" name="two_factor_code" required />
            </div>

            <!-- Captcha -->
            <div class="flex items-center mb-4">
                <input type="checkbox" id="captchaCheckbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                <label for="captchaCheckbox" class="ml-2 text-sm text-gray-600">{{ __('No soy un robot') }}</label>
            </div>

            <!-- Advertencia de captcha -->
            <div id="captchaWarning" class="text-red-600 text-sm mb-4 hidden">
                Debes completar el captcha antes de verificar.
            </div>

            <!-- Botón de Verificar -->
            <button type="submit" class="w-full bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 disabled:bg-gray-400" id="verifyButton" disabled>Verificar</button>
        </form>

        <!-- Botón de reenviar código con cuenta regresiva -->
        <button id="resendButton" class="mt-4 w-full bg-gray-500 text-white px-4 py-2 rounded-md cursor-not-allowed" disabled>
            Reenviar código (60)
        </button>

        <!-- Mensaje de éxito al reenviar el código -->
        <div id="resendMessage" class="mt-4 text-green-600 hidden">
            El código ha sido reenviado exitosamente.
        </div>
    </div>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const resendButton = document.getElementById("resendButton");
            const verifyButton = document.getElementById("verifyButton");
            const captchaCheckbox = document.getElementById("captchaCheckbox");
            const captchaWarning = document.getElementById("captchaWarning");
            const resendMessage = document.getElementById("resendMessage"); // Mensaje de reenviar código
            let resendCountdown = 60;

            // Habilitar botón de "Verificar" solo si el captcha está marcado
            captchaCheckbox.addEventListener("change", () => {
                verifyButton.disabled = !captchaCheckbox.checked;
                captchaWarning.classList.toggle("hidden", captchaCheckbox.checked);
            });

            // Mostrar advertencia si se intenta enviar sin captcha
            document.getElementById("twoFactorForm").addEventListener("submit", function(event) {
                if (!captchaCheckbox.checked) {
                    event.preventDefault();
                    captchaWarning.classList.remove("hidden");
                }
            });

            // Función de cuenta regresiva para el botón de "Reenviar código"
            function startResendCountdown() {
                resendButton.textContent = `Reenviar código (${resendCountdown})`;
                resendButton.disabled = true;
                resendButton.classList.add("cursor-not-allowed", "bg-gray-500");
                resendButton.classList.remove("bg-indigo-600", "hover:bg-indigo-700", "cursor-pointer");
                resendMessage.classList.add("hidden"); // Ocultar mensaje de éxito

                const resendTimer = setInterval(() => {
                    resendCountdown--;
                    resendButton.textContent = `Reenviar código (${resendCountdown})`;

                    if (resendCountdown <= 0) {
                        clearInterval(resendTimer);
                        resetResendButton();
                    }
                }, 1000);
            }

            function resetResendButton() {
                resendButton.textContent = "Reenviar código";
                resendButton.classList.remove("cursor-not-allowed", "bg-gray-500");
                resendButton.classList.add("bg-indigo-600", "hover:bg-indigo-700", "cursor-pointer");
                resendButton.disabled = false;
                resendCountdown = 60; // Reiniciar el contador para la próxima vez
            }

            // Iniciar cuenta regresiva en "Reenviar código" al cargar la página
            startResendCountdown();

            // Reiniciar la cuenta regresiva al hacer clic en "Reenviar código"
            resendButton.addEventListener("click", function() {
                startResendCountdown(); // Reiniciar cuenta regresiva
                // Hacer la solicitud AJAX para reenviar el código
                fetch("{{ route('2fa.resend') }}", {
                    method: "POST",
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({})
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error al reenviar el código.');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log(data.message); // Mostrar el mensaje de éxito
                    resendMessage.classList.remove("hidden"); // Mostrar mensaje de éxito
                })
                .catch(error => {
                    console.error('Error:', error); // Manejar errores
                });
            });
        });
    </script>
</x-guest-layout>
