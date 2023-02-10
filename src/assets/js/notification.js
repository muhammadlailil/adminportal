const IntervalNotification = Number(document.querySelector('meta[name="notification-interval"]').getAttribute('content'));
const AdminBaseUrl = document.querySelector('meta[name="admin-base-url"]').getAttribute('content');

loadNotification();
if(IntervalNotification){
    setInterval(function() {
        loadNotification();
    },IntervalNotification*1000);
}



const headerNotification = document.querySelector('.header-navigation .notification .dropdown-notification')
function loadNotification(){
    fetch(`${AdminBaseUrl}/notification-admin/list`, {
        method: "GET",
    }).then(async (res) => {
        if (res.status == 200) {
            const data = await res.json();
            const place = document.querySelector('.notification-list #notification-list-items')
            headerNotification.querySelector('.count').innerHTML = data.total
            if(data.items.length){
                headerNotification.querySelector('.icon').classList.remove('d-none')
                let htmls = ''
                for(let[i,row] of data.items.entries()){
                    htmls += `<li class="items">
                            <a href="${AdminBaseUrl}/notification-admin/read/${row.id}" class="d-flex unread">
                                <div class="icons">
                                    <i class="isax-b icon-notification-bing"></i>
                                </div>
                                <div class="d-flex flex-column">
                                    <p class="title">${row.title}</p>
                                    <span class="desc">${row.description}</span>
                                    <span class="date">${row.date}</span>
                                </div>
                            </a>
                        </li>`
                }
                place.innerHTML = htmls
            }else{
                place.innerHTML = `<li class="items empty-notification">
                        <span>You don't have notification</span>
                    </li>`  
                headerNotification.querySelector('.icon').classList.add('d-none')              
            }
            
        }
    });
}