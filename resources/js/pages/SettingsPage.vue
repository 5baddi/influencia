<template>
   <div class="settings">
      <div class="hero">
         <div class="hero__intro">
            <h1>Settings</h1>
            <ul class="breadcrumbs">
               <li>
                  <a href="#">Dashboard</a>
               </li>
               <li>
                  <a href="#">Settings</a>
               </li>
            </ul>
         </div>
      </div>
      <div class="p-1">
         <div class="card">
            <header>
               <h2>Application settings</h2>
            </header>
            <div class="card__content">
               <form action="#">
                  <div class="control">
                     <label>Instagram session id</label>
                     <input type="text" placeholder="Session" />
                     <p>Can be found in your sessions browser.</p>
                  </div>
                  <div class="control">
                     <button class="btn btn-success">Save</button>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</template>
