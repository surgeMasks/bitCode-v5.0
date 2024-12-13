<script lang="ts">
  import { onMount } from 'svelte';
  import api from '$lib/apis/dashboard';

  let projects: { id: number; image_path: string; title: string; description: string; price: number }[] = [];

  let showModal = false;

  // Form inputs
  let title = '';
  let description = '';
  let price = 0;
  let image: File | null = null;
  let file: File | null = null;

  // Fetch projects from your API
  onMount(async () => {
    const response = await api.getProjects();
    if (response.ok) {
      projects = await response.json();
      console.log(projects);
    } else {
      console.error('Failed to fetch projects');
    }
  });

  // Handle form submission
  const addProject = async () => {
    const formData = new FormData();
    formData.append('title', title);
    formData.append('description', description);
    formData.append('price', price.toString());
    if (image) formData.append('image', image);
    if (file) formData.append('file', file);

    const response = await fetch('/api/projects', {
      method: 'POST',
      body: formData,
    });

    if (response.ok) {
      const newProject = await response.json();
      projects.push(newProject); // Add the new project to the list
      closeModal();
    } else {
      console.error('Failed to add project');
    }
  };

  // Open modal
  const openModal = () => {
    showModal = true;
  };

  // Close modal
  const closeModal = () => {
    showModal = false;
    title = '';
    description = '';
    price = 0;
    image = null;
    file = null;
  };
</script>

<style>
  .modal {
    position: fixed;
    inset: 0;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .modal-content {
    background: white;
    border-radius: 0.5rem;
    padding: 2rem;
    width: 90%;
    max-width: 500px;
  }

  .project-card {
    transition: transform 0.2s, box-shadow 0.2s;
  }

  .project-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
  }

  .project-image {
    height: 200px;
    object-fit: cover;
  }

  .purchase-button {
    background-color: #1d4ed8;
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    transition: background-color 0.2s;
  }

  .purchase-button:hover {
    background-color: #2563eb;
  }

  .close-button {
    background-color: #d32f2f;
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    transition: background-color 0.2s;
    float: right;
  }

  .close-button:hover {
    background-color: #b71c1c;
  }
</style>

<main class="p-6">
  <!-- Add Project Button -->
  <button
    class="purchase-button mb-6"
    on:click={openModal}
  >
    Add Project
  </button>

  <!-- Modal -->
  {#if showModal}
    <div class="modal">
      <div class="modal-content">
        <h2 class="text-xl font-semibold mb-4">Add New Project</h2>
        <form on:submit|preventDefault={addProject}>
          <div class="mb-4">
            <label class="block text-gray-700">Title</label>
            <input
              type="text"
              bind:value={title}
              class="border w-full p-2 rounded"
              required
            />
          </div>
          <div class="mb-4">
            <label class="block text-gray-700">Description</label>
            <textarea
              bind:value={description}
              class="border w-full p-2 rounded"
              required
            ></textarea>
          </div>
          <div class="mb-4">
            <label class="block text-gray-700">Price</label>
            <input
              type="number"
              bind:value={price}
              class="border w-full p-2 rounded"
              required
            />
          </div>
          <div class="mb-4">
            <label class="block text-gray-700">Image</label>
            <input
              type="file"
              on:change={(e) => { const target = e.target as HTMLInputElement; if (target.files) image = target.files[0]; }}
              class="border w-full p-2 rounded"
            />
          </div>
          <div class="mb-4">
            <label class="block text-gray-700">File</label>
            <input
              type="file"
              on:change={(e) => { const target = e.target as HTMLInputElement; if (target && target.files) file = target.files[0]; }}
              class="border w-full p-2 rounded"
            />
          </div>
          <div class="flex justify-end">
            <button type="button" class="close-button mr-2" on:click={closeModal}>Cancel</button>
            <button type="submit" class="purchase-button">Add Project</button>
          </div>
        </form>
      </div>
    </div>
  {/if}

  <!-- Projects Grid -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    {#each projects as project}
      <div class="project-card bg-white rounded-lg shadow-md p-4">
        <img src={project.image_path} alt={project.title} class="project-image w-full rounded-md" />
        <h3 class="text-xl font-semibold mt-4">{project.title}</h3>
        <p class="mt-2 text-gray-600">{project.description}</p>
        <p class="mt-4 font-semibold text-lg">${project.price}</p>
      </div>
    {/each}
  </div>
</main>
