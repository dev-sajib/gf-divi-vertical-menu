/** @format */

// External Dependencies
import React, { Component } from 'react'
// Internal Dependencies
import './style.css'

class DFVerticalMenu extends Component {
    static slug = 'dfv_vertical_menu'
    get_menu_items(params) {
        fetch(window.ETBuilderBackend.ajaxUrl)
            .then((response) => {
                if (!response.ok) {
                    throw new Error('Network response was not ok')
                }
                return response.json()
            })
            .then((data) => {
                console.log(data) // Handle your menu items here
                const menuContainer = document.getElementById('your-menu-container')
                data.items.forEach((item) => {
                    const li = document.createElement('li')
                    li.innerHTML = `<a href="${item.url}">${item.title}</a>`
                    menuContainer.appendChild(li)
                })
            })
            .catch((error) => console.error('Error fetching menu items:', error))
    }
    render() {
        const ajaxurl = window.ETBuilderBackend.ajaxUrl
        console.log(ajaxurl)

        if (ajaxurl) {
            // document.addEventListener('DOMContentLoaded', function() {
            
                var data = {
                    action: 'get_all_posts'  // The action should match the PHP handler
                };
            
                // Make the Ajax request
                fetch(ajaxurl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'  // Required for WordPress Ajax requests
                    },
                    body: new URLSearchParams(data).toString()  // Properly format the body for x-www-form-urlencoded
                })
                .then(response => response.json())
                .then(data => {
                    // Log the response to verify
                    console.log('Response from server:', data);
                })
                .catch(error => console.error('Error:', error));
            // });
        }
        return (
            <div className='vertical-menu'>
                {/* <ul className='dfv-parent-menu dfv-menu'>
                    <li>
                        <a href='http://diviflash-release-test.local/vertical-menu/'>Home</a>
                    </li>
                    <li>
                        <a href='#'>Home sub</a>
                        <ul className='dfv-parent-menu dfv-sub-menu'>
                            <li>
                                <a href='#'>Home sub two</a>
                            </li>
                        </ul>
                    </li>
                <li>
                    <a href='#'>About Us</a>
                </li>
                <li>
                    <a href='#'>Services</a>
                </li>
                <li>
                    <a href='#'>Services 1</a>
                    <ul className='dfv-parent-menu dfv-sub-menu'>
                        <li>
                            <a href='#'>Service 1 sub</a>
                            <ul className='dfv-parent-menu dfv-sub-menu'>
                                <li>
                                    <a href='#s'>service 1 subb</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href='http://diviflash-release-test.local/sample-page/'>Contact Page</a>
                    </li>
                    </ul> */}
            </div>
        )
    }
}

export default DFVerticalMenu
