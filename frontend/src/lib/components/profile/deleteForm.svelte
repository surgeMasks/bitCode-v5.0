<script lang="ts">
    import { fade, scale } from "svelte/transition";
    import { cubicInOut } from "svelte/easing";
    import Overlay from "$lib/components/ui/overlay.svelte";
    import ConfirmButton from "$lib/components/buttons/confirmButton.svelte";
    import { deleteMyProfile } from "$lib/handlers/updateHandlers";
    import { goto } from "$app/navigation";

    export let closeDeleteProfileModal: () => void;
    let isResponseLoading = false;

    async function deleteProfile() {
      isResponseLoading = true;
      try {
        await deleteMyProfile(password);
        goto("/auth/login");
      } catch (error: any) {
        password = "";
      } finally {
        isResponseLoading = false;
        showConfirmModal = false;
      }
  }

    let password = "";
    let showConfirmModal = false;
    let show_password = false;

    $: disable = (isResponseLoading || password.length === 0 || showConfirmModal); ;
</script>

<Overlay>
    <div class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2  bg-white p-8 rounded-lg shadow-lg z-50 h-68" transition:scale={{ duration: 300, easing: cubicInOut }}>
      <h1 class="text-2xl bg-black text-white rounded-sm p-2 mb-12 text-center">Delete Profile</h1>
        <div in:fade={{ duration: 300, easing: cubicInOut }} class="w-full h-full items-between flex flex-col">
          <p class="mb-4 mx-2">Please confirm your password before deleting..!</p>
          <div class="password-input mb-12">
            <input 
              type={show_password ? 'text' : 'password'}
              placeholder="Password"
              required 
              class="input border border-gray-300 rounded w-full px-4 py-2 focus:outline-none focus:border-blue-500" 
              maxlength="15" 
              on:input={(e) => {
                  if (e.target instanceof HTMLInputElement) {
                    password = e.target.value;
                  }
                }
              } 
            /> 
            <button type="button" on:click={ () => show_password = !show_password }>
              <i class={show_password ? 'fas fa-eye' : 'fas fa-eye-slash'}></i>
            </button>
          </div>
          
          <div class="flex justify-between mt-4 space-x-4 w-full">
            <button class="w-28 h-10 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded mr-2" disabled={disable}
                    on:click={() => {showConfirmModal = true;}}>Confirm</button>
            <button 
                class="w-28 h-10 bg-gray-300 hover:bg-gray-400 text-grey font-bold py-2 px-4 rounded"
                on:click={closeDeleteProfileModal}>
                Cancel
            </button>
          </div>
        </div>
    </div>
</Overlay>
{#if showConfirmModal}
    <ConfirmButton onConfirm={deleteProfile} onCancel={()=> showConfirmModal = false} msg="Are you sure you want to delete your profile?"/>
{/if}

<style>
    .password-input {
      position: relative;
      flex-direction: row;
      align-items: center;
      justify-content: center;
      width: 100%;
      gap: 10px;
    }
    .password-input button {
        position: absolute;
        right: 6px;
        top: 40%;
        transform: translateY(-50%);
        background: none; /* Remove background */
        border: none; /* Remove border */
    }
</style>