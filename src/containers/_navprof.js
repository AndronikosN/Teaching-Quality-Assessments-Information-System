export default [
    {
      _name: 'CSidebarNav',
      _children: [
        
        {
          _name: 'CSidebarNavDropdown',
          name: 'Αξιολόγηση διδακτικού έργου',
          route: '/kath-omea',
          
          items: [
            {
            name : 'Τα μαθήματα μου',
            to: '/kath-omea/mathimataKath'
            },
            {
              name : 'Αξιολογήσεις μαθημάτων μου',
              to: '/kath-omea/aksiologhseis'
            },
            {
              name : 'Ερωτηματολόγια τμήματος',
              to: '/kath-omea/erotimatologiaTmhmatos'
            }
          ]
        },

        {
          _name: 'CSidebarNavDivider',
          _class: 'm-2'
        }
        
      ]
    }
  ]