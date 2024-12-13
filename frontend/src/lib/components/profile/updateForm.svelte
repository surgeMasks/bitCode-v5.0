<script lang="ts">
    import Overlay from '$lib/components/ui/overlay.svelte';
    import { cubicInOut } from 'svelte/easing';
    import { scale } from "svelte/transition";
    import { Spinner } from 'flowbite-svelte';
    import Password from '$lib/components/profile/password.svelte';
    
    export let closeModal: () => void;
    export let updatePassword: (oldPassword: string, newPassword: string, confirmPassword: string) => Promise<void>;

    let isResponseLoading = false;
    let oldPassword = '';
    let newPassword = '';
    let confirmPassword = '';

    async function changePassword() {
        isResponseLoading = true;
        if (!isPasswordMatch) {
            isResponseLoading = false;
            return;
        }
        try {
            await updatePassword(oldPassword, newPassword, confirmPassword);
            closeModal();
        } catch (error: any) {
        } finally {
            isResponseLoading = false;
            oldPassword = "";
            newPassword = "";
            confirmPassword = "";
        }
        
    }

    $: isPasswordBad = (!oldPassword || !newPassword || !confirmPassword);
    $: isPasswordMatch = newPassword === confirmPassword;
</script>

<Overlay>
    <div class="z-50 relative bg-white rounded-lg p-8 mx-4 max-w-md text-center flex flex-col gap-4" transition:scale={{ duration: 300, easing: cubicInOut }}>
        <h2 class="text-2xl bg-black text-white mb-6 rounded-sm p-2">Change Password</h2>
        <Password bind:value={oldPassword} placeholder="Old Password" />
        <Password bind:value={newPassword} placeholder="New Password" />
        <Password bind:value={confirmPassword} placeholder="Confirm Password" />        
        {#if !isPasswordMatch && (confirmPassword.length + newPassword.length > 0 )}
            <p class="text-red-500 text-sm mb-2">Passwords do not match</p>
        {/if}
        <div class="flex justify-between mt-6">
            <button class="bg-blue-500 w-28 h-12 hover:bg-blue-600 text-white py-2 text-center rounded mr-4 focus:outline-none" on:click={changePassword} disabled={isPasswordBad || isResponseLoading}>
                {#if isResponseLoading}
                    <Spinner class="text-center" size="6" color="blue" />
                {:else}
                    Confirm
                {/if}
            </button>
            <button class="bg-gray-300 w-28 h-12 hover:bg-gray-400 text-gray-800 py-2 text-center rounded focus:outline-none" on:click={closeModal}>Cancel</button>
        </div>
    </div>
</Overlay>