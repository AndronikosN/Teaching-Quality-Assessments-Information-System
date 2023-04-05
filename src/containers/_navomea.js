export default [
    {
      _name: 'CSidebarNav',
      _children: [
        
        {
          _name: 'CSidebarNavItem',
          name: 'Ερωτηματολόγιο',
          to: '/kath-omea',
          
        },

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
              name : 'Δημιουργιά ερωτηματολογίου',
              to: '/kath-omea/dhmiourgiaErot'
            },
            {
              name : 'Ερωτηματολόγια',
              to: '/kath-omea/erotOmea'
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