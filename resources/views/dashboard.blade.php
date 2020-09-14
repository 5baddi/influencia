<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    <main id="main" class="dashboard">
        <aside class="dashboard__sidebar">
            <header>
                <div class="dashboard__sidebar--content">
                    <div class="logo">
                        <img src="http://angular-material.fusetheme.com/assets/images/logos/fuse.svg" alt="logo">
                    </div>
                    <h1>INFLUENCIA</h1>
                </div>
                <button class="dashboard__sidebar--toggle btn">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </header>
            <div class="dashboard__sidebar__profile">
                <h2>Charlie Adams</h2>
                <p>adams.charlie@mail.com</p>
                <div class="avatar">
                        <img src="http://angular-material.fusetheme.com/assets/images/avatars/Velazquez.jpg" alt="avatar">
                </div>
            </div>
            <nav class="dashboard__sidebar__navigation">
                <ul>
                    <li>
                        <a href="#">
                            <span class="icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" class="sc-fznyYp kgPnwn"><g fill="none" fill-rule="evenodd"><circle cx="12" cy="12" r="12"></circle><path fill="#fff" fill-rule="nonzero" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm7.93 9H13V4.07c3.61.45 6.48 3.32 6.93 6.93zM4 12c0-4.07 3.06-7.44 7-7.93v15.86c-3.94-.49-7-3.86-7-7.93zm9 7.93V13h6.93A8.002 8.002 0 0113 19.93z"></path></g></svg>
                            </span>
                            <span class="text">Campaigns</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span class="icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" class="sc-fzpisO jZmyVc"><g fill="none" fill-rule="evenodd"><circle cx="12" cy="12" r="12"></circle><path fill="#fff" d="M2 2h2v20H2V2zm20 18v2H4v-2h18zM7 8h2v10H7V8zm5-4h2v14h-2V4zm5 8h2v6h-2v-6z"></path></g></svg>
                            </span>
                            <span class="text">Trackers</span>
                        
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <div class="icon">
                                <svg width="18" height="18" viewBox="0 0 18 18" class="sc-fzqKVi gwUGVI"><g fill="none" fill-rule="evenodd"><circle cx="9" cy="9" r="9"></circle><path fill="#fff" d="M12.495 3.39l2.123 2.123-2.123 2.122-2.122-2.122 2.122-2.123zm-5.745.36v3h-3v-3h3zm7.5 7.5v3h-3v-3h3zm-7.5 0v3h-3v-3h3zm5.745-9.982L8.25 5.505l4.245 4.245 4.245-4.245-4.245-4.237zM8.25 2.25h-6v6h6v-6zm7.5 7.5h-6v6h6v-6zm-7.5 0h-6v6h6v-6z"></path></g></svg>
                            </div>
                            <div class="text">
                                Brands
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <div class="icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" class="sc-fzoJMP cyFmdx"><g fill="none" fill-rule="evenodd"><circle cx="12" cy="12" r="12"></circle><path fill="#fff" d="M19.43 12.98c.04-.32.07-.64.07-.98 0-.34-.03-.66-.07-.98l2.11-1.65c.19-.15.24-.42.12-.64l-2-3.46a.5.5 0 00-.61-.22l-2.49 1c-.52-.4-1.08-.73-1.69-.98l-.38-2.65A.488.488 0 0014 2h-4c-.25 0-.46.18-.49.42l-.38 2.65c-.61.25-1.17.59-1.69.98l-2.49-1a.566.566 0 00-.18-.03c-.17 0-.34.09-.43.25l-2 3.46c-.13.22-.07.49.12.64l2.11 1.65c-.04.32-.07.65-.07.98 0 .33.03.66.07.98l-2.11 1.65c-.19.15-.24.42-.12.64l2 3.46a.5.5 0 00.61.22l2.49-1c.52.4 1.08.73 1.69.98l.38 2.65c.03.24.24.42.49.42h4c.25 0 .46-.18.49-.42l.38-2.65c.61-.25 1.17-.59 1.69-.98l2.49 1c.06.02.12.03.18.03.17 0 .34-.09.43-.25l2-3.46c.12-.22.07-.49-.12-.64l-2.11-1.65zm-1.98-1.71c.04.31.05.52.05.73 0 .21-.02.43-.05.73l-.14 1.13.89.7 1.08.84-.7 1.21-1.27-.51-1.04-.42-.9.68c-.43.32-.84.56-1.25.73l-1.06.43-.16 1.13-.2 1.35h-1.4l-.19-1.35-.16-1.13-1.06-.43c-.43-.18-.83-.41-1.23-.71l-.91-.7-1.06.43-1.27.51-.7-1.21 1.08-.84.89-.7-.14-1.13c-.03-.31-.05-.54-.05-.74 0-.2.02-.43.05-.73l.14-1.13-.89-.7-1.08-.84.7-1.21 1.27.51 1.04.42.9-.68c.43-.32.84-.56 1.25-.73l1.06-.43.16-1.13.2-1.35h1.39l.19 1.35.16 1.13 1.06.43c.43.18.83.41 1.23.71l.91.7 1.06-.43 1.27-.51.7 1.21-1.07.85-.89.7.14 1.13zM12 8c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm0 6c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"></path></g></svg>
                            </div>
                            <div class="text">
                                Users
                            </div>
                            
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>
        <div class="dashboard__content">
            <div class="dashboard__navigation">
                <div class="dashboard__navigation--profile">
                    <button class="btn">
                        <div class="avatar">
                            <img src="http://angular-material.fusetheme.com/assets/images/avatars/Velazquez.jpg" alt="">
                        </div>
                        <div class="text">
                            <p>Charlie Adams</p>
                            <div class="icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" color="#000629" class="sc-fzqAbL fPXfOL"><g fill="none" fill-rule="evenodd"><circle cx="12" cy="12" r="12"></circle><path fill="#000" d="M12.492 12.283L7.306 7 5 9.35 12.492 17 20 9.35 17.677 7z"></path></g></svg>
                            </div>
                        </div>
                    </button>
                </div>
            </div>
            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Exercitationem officiis illo nobis eligendi quia, quos ab ut aliquid tempore in! Autem, sed corporis nihil harum dolorem amet consectetur perferendis quasi qui laboriosam unde, explicabo hic sint aperiam dolorum sunt, magni inventore quod! Laboriosam dolorum ut culpa nulla quaerat dolore! Nulla, pariatur earum laboriosam a at eligendi ullam! Totam perspiciatis reiciendis perferendis, cupiditate, nemo quasi delectus error, sed illum quod quidem nihil deleniti quisquam recusandae! Autem, quibusdam ad? Sit ea exercitationem eos adipisci, cumque consectetur culpa earum quasi odio maiores neque reprehenderit dolorum alias ut, tenetur repellat quam quo animi excepturi eveniet cupiditate. Ex earum molestiae vitae sed ipsum cum ullam inventore, delectus exercitationem ratione blanditiis omnis illum dignissimos rerum perferendis quod voluptatem possimus quos mollitia sequi illo dolore dolorem? Asperiores id facilis praesentium natus, harum ea quas porro in sequi perferendis ut laborum accusamus libero voluptas unde rerum labore similique. Labore quod voluptates voluptatibus. Atque ducimus quasi itaque sequi repellendus dolor illum nisi optio, voluptatum necessitatibus, quo beatae modi, voluptate placeat quae? Eos, mollitia nihil molestiae perspiciatis eligendi consequatur non earum nobis repellendus molestias sint facilis ea reprehenderit assumenda quas quaerat. Eum deserunt ipsa dolore nisi error quas vel adipisci.</p>
        </div>
    </main>
</body>
</html>