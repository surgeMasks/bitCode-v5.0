<script lang="ts">
    import { fetchMyProfile } from "$lib/handlers/fetchHandlers";
    import { updateMyProfile, updatePassword} from "$lib/handlers/updateHandlers";
    import { onMount } from "svelte";
    import UpdatePasswordForm from "$lib/components/profile/updateForm.svelte";
    import ProfileDeleteModel from "$lib/components/profile/deleteForm.svelte";
    // import api from '$lib/apis/profile';
    import Loading from "$lib/components/ui/loading.svelte";
  
    import { fade, slide } from "svelte/transition";
    // import {BadgeCheckOutline} from 'flowbite-svelte-icons';
    import { cubicInOut } from "svelte/easing";
    // import { Spinner } from "flowbite-svelte";
    // import { Alert } from '$stores/globalStore';
    import { goto } from "$app/navigation";
    import apiAuth from '$lib/apis/auth';
  
    let profile: { full_name: any; email: any; username:any; university_id: any; uni_reg_no: any };
  
    let originalProfile: { full_name: any; email: any; username:any; university_id: any; uni_reg_no: any };
    
    let isLoading = false;
    let isEditing = false;
    let isProfileChanged = false;
  
    let isPasswordModalOpen = false;
      
    let isDeleteProfileModalOpen = false;
  
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  
    function openPasswordModal() {
      isPasswordModalOpen = true;
    }
  
    async function loadProfile() {
      isLoading = true;
      const new_profile = await fetchMyProfile();
      //const new_profile = {full_name: 'Tharusha', email: 'tharusha@gmail.com', user_name: 'TheNobleStag', university: 'UOM', uni_reg_number: '200073D'}
  
      profile = { ...new_profile };

      originalProfile = { ...profile };
      isLoading = false;
    }
  
    function getChangedFields(profile: any, originalProfile: any) {
        const changedFields: { [key: string]: any } = {};
        for (const key in profile) {
          if (profile[key] !== originalProfile[key]) {
            changedFields[key] = profile[key];
          }
        }
        return changedFields;
    }
    
    async function updateProfile() {
      isLoading = true;
      try {
        const changedFields = getChangedFields(profile, originalProfile);
  
        if (Object.keys(changedFields).length > 0) {
          await updateMyProfile(changedFields);
  
          await loadProfile(); // Reload profile after updating
          isProfileChanged = false; // Reset flag after updating
        }
        isEditing = false;
        isLoading = false;
      } catch (error: any) {
        isLoading = false;
      } 
    } 
  
    function handleInputChange() {
      isProfileChanged = !compareProfiles(profile, originalProfile);
    }
  
    function compareProfiles(profile1: any, profile2: any) {
      return JSON.stringify(profile1) === JSON.stringify(profile2);
    }
  
    function enableEditing() {
      isEditing = true;
    }
  
    function cancelEditing() {
      profile = { ...originalProfile }; // Revert changes
  
      isEditing = false;
      isProfileChanged = false;
    }
  
    function openDeleteProfileModal() {
      isDeleteProfileModalOpen = true;
    }
  
    onMount(async ()=>{
      isLoading = true;
      await loadProfile();
      isLoading = false;
    });
  
    async function handleLogout() {
          try {
              // Send logout signal to backend
              const response = await apiAuth.logout();
  
              if (response.ok) {
                  // If logout was successful, redirect the user to the login page or any other page
                  localStorage?.removeItem('token');
                  goto("/auth/login"); // Replace '/login' with your desired redirect URL
              } else {
                  // Handle error if logout was not successful
                  console.error('Logout failed');
              }
          } catch (error) {
              console.error('Error during logout:', error);
          }
      }
  
  </script>
  
   
  <div class="flex justify-center items-center min-h-screen">
    <div class="relative bg-white shadow-md p-10 rounded-lg max-w-4xl w-full opacity-100 mt-10 max-h-full">
      <button
          on:click|preventDefault={handleLogout}
          class="absolute right-10 z-20 px-4 py-2 text-white bg-red-600 rounded-lg w-28 h-10 hover:bg-red-800 flex items-center justify-center space-x-2 hidden md:flex"
      >
          <iconify-icon icon="tabler:arrow-right"></iconify-icon>
          <span>Logout</span>
      </button>
  
      {#if profile && !isLoading}
        <div class="topsticky bg-white rounded-lg p-4 z-9">
          <div class="flex justify-center xl">
            <iconify-icon icon="iconoir:profile-circle"></iconify-icon>
          </div>
      
          <div class="text-center mb-6">
            <h1 class="text-3xl font-semibold text-gray-800 mb-2">{originalProfile.full_name}</h1>
          </div>
        </div>
  
        <div class="flex flex-col w-full sm:w-auto sm:mx-10 md:mx-15 gap-8 md:grid md:grid-cols-2">
          {#if isEditing}
            <div>
              <label for="full_name" class="block text-gray-600 text-lg mb-1">Full Name:</label>
              <input id="full_name" type="text" bind:value={profile.full_name} on:input={handleInputChange} class="w-full text-gray-600 text-lg border border-gray-300 bg-gray-100 rounded p-2" disabled={!isEditing}>  
            </div>
          {/if}
  
        <div>
          <div class="flex flex-row mb-1">
            <label for="email" class="block text-gray-600 text-lg">
              Email: &nbsp;
            </label>
          </div>
          <input id="email" type="email" bind:value={profile.email} on:input={handleInputChange} class="w-full  text-gray-600 text-lg border border-gray-300 bg-gray-100 rounded p-2" disabled={!isEditing}> 
        </div>

        <div>
            <label for="user_name" class="block text-gray-600 text-lg mb-1">User Name:</label>
            <input id="user_name" bind:value={profile.username} on:input={handleInputChange} class="w-full  text-gray-600 text-lg border border-gray-300 bg-gray-100 rounded p-2 resize-none" disabled={!isEditing}/>
          </div>

        <div>
          <label for="university" class="block text-gray-600 text-lg mb-1">University:</label>
          <input id="university" bind:value={profile.university_id} on:input={handleInputChange} class="w-full  text-gray-600 text-lg border border-gray-300 bg-gray-100 rounded p-2 resize-none" disabled={!isEditing}/>
        </div>

        <div>
          <label for="uni_reg_number" class="block text-gray-600 text-lg mb-1">University Registration Number:</label>
          <input id="uni_reg_number" bind:value={profile.uni_reg_no} on:input={handleInputChange} class="w-full  text-gray-600 text-lg border border-gray-300 bg-gray-100 rounded p-2 resize-none" disabled={!isEditing}/>
        </div>

        {#if isEditing}
          <div class="justify-center items-end flex" in:fade={{delay:300, duration:200}} out:fade={{duration:0}}>
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-4 w-42 h-10" on:click={updateProfile}>Save Changes</button>
            <button class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded h-10" on:click={cancelEditing}>Cancel</button>
          </div>
        {/if}
      </div>
      <div class="flex justify-center bottom-0 mt-8 bg-white p-4 w-full" transition:slide={{duration:200, easing:cubicInOut}}>
        {#if !isEditing }
          <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-42 min-h-10" on:click={enableEditing}>Edit Profile</button>
          <button class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded ml-4  w-42 min-h-10" on:click={openPasswordModal}>Change Password</button>
          <button class="bg-red-700 hover:bg-red-900 text-white font-bold py-2 px-4 rounded ml-4  w-42 min-h-10" on:click={openDeleteProfileModal}>Delete Profile</button>
        {/if}
      </div>
  
      {:else}
        <Loading/>
      {/if}
      </div>
    </div>
    {#if isPasswordModalOpen}
      <UpdatePasswordForm closeModal={() => {isPasswordModalOpen = false}} updatePassword={updatePassword} />
    {/if}
  
    {#if isDeleteProfileModalOpen}
      <ProfileDeleteModel closeDeleteProfileModal={() => {isDeleteProfileModalOpen = false}} />
    {/if}
  
<style>
.topsticky {
    position: sticky;
    top: -18px;
    z-index: 8;
}

:global(.alert) {
    z-index: 100;
    }
</style>