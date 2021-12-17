introJs()
  .setOptions({
    steps: [
      {
        intro: 'Welcome to CMSQlite.'
      },
      {
        element: document.getElementById('start__welcome'),
        intro: `Welcome!<br>Get quick access to common tasks.`
      },
      {
        element: document.getElementById('start__loggedin_users'),
        intro: `Shows you the users that have been logged in`
      },
      {
        element: document.getElementById('start__last_edit_articles'),
        intro: `Quick access to articles that were last edited`
      },
      {
        element: document.getElementById('start__top_articles'),
        intro: `A small statistic which articles were viewed most often.<br>
You can reset the counter if you like.`
      },
      {
        element: document.getElementById('profile-menu'),
        intro: 'Change your profile and logout from the backend'
      },
      {
        element: document.getElementById('admin-menu__articles'),
        intro: 'Manage articles. Add and edit content of your various pages'
      },
      {
        element: document.getElementById('admin-menu__media'),
        intro: `Manage your public files, images, videos, etc. in this section. <br>
The files can be added to your articles (pages) with your editor.`
      },
      {
        element: document.getElementById('admin-menu__categories'),
        intro: `Categories allow you to group articles. This gives you the 
        possibility to create e.g. news sections, FAQs or other information 
        that should be displayed in a group. However grouped content has to be
        programmed into your template.`
      },
      {
        element: document.getElementById('admin-menu__menus'),
        intro: `Menus make your articles available to the visitors of your homepage.<br>
Creating an article in 'Articles' will not show it on your homepage. You need to create an 
entry in any of your menus and link the article to it. <br>
You can have as many menus as you like but the place and the look has to be programmed
into your template.`
      },
      {
        element: document.getElementById('admin-menu__users'),
        intro: `Manage users to this administration panel (backend).`
      },
      {
        element: document.getElementById('admin-menu__settings'),
        intro: `Manage your homepage settings like the basic language of your homepage,
        the template (the look and feel of your homepage) or en-/disabling this tour and others.`
      },
      {
        intro: `Thank you for using CMSQlite. I hope you will enjoy working with it.
        <br>The tour will be disabled but you can enable it at any time in the settings
by setting the item 'tour' to 1.`
      }
    ]
  })
  .oncomplete(() => {
    fetch('/admin/settings/disable-tour', {
      method: 'get',
      headers: {
        'Content-Type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
      }
    })
  })
  .start()