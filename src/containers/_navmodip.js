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
          
        ]
      },

      { 
        _name: 'CSidebarNavDropdown',
        name: 'Στοιχεία ιδρύματος',
        route: '/modip',
        items : [
          {
            name: 'Τμήματα ιδρύματος',
            to: '/modip/tmhmata'
          },
          {
            name: 'Καθηγητές ιδρύματος',
            to: '/modip/kathhghtes'
          },
          {
            name: 'Μαθήματα ιδρύματος',
            to: '/modip/mathhmata'
          },
          {
            name: 'Ερωτηματολόγια τμημάτων',
            to: '/modip/erotimatologiaTmhmatwn'
          },
          {
            name: 'Αξιολογήσεις μαθημάτων',
            to:'/modip/aksiologhseisIdrymatos'
          }
        ]
      },
     /* 
      {
        _name: 'CSidebarNavDivider',
        _class: 'm-2'
      }
*/
    ]
  }
]