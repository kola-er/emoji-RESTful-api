<?php
/**
 * This is a collection of helper methods for displaying some html pages' content.
 *
 * @package Kola\Api\Emoji\Helper\HtmlDisplay
 * @author  Kolawole ERINOSO <kola.erinoso@gmail.com>
 * @license MIT <https://opensource.org/licenses/MIT>
 */
namespace Kola\Api\Emoji\Helper;

class HtmlDisplay
{
	/**
	 * Display Welcome page content
	 *
	 * @return string Welcome page content
	 */
    public static function welcome($img)
    {
        return "<head>" .
		"<style>
			table {
				border-collapse: collapse;
			}

			table, td, th {
				border: 1px solid black;
				background-color: aliceblue;
    			text-align: center;
			}
		</style></head>" .
		"<div style='background:url($img) no-repeat;background-size:cover'>" .
        "<div style='text-align:center;color:#E5E5E5;padding-top:300px'>" .
        "<h1>Welcome to Naijamoji.</h1>" .
        "<span style='font-weight:normal;font-size:16px'>Register <a href='/register'>here</a></span>" .
        "</div>" .
        "</div>" .
		"<div><table style='width:100%'>" .
		"<tr>
    		<th>EndPoint</th>
    		<th>Functionality</th>
    	</tr>
    	<tr>
    		<td>POST /auth/login</td>
    		<td>Logs a user in</td>
  		</tr>
  		<tr>
    		<td>GET /auth/logout</td>
    		<td>Logs a user out</td>
  		</tr>
  		<tr>
    		<td>GET /emojis</td>
    		<td>Lists all the created emojis</td>
  		</tr>
  		<tr>
    		<td>GET /emojis/{id}</td>
    		<td>Gets a single emoji</td>
  		</tr>
  		<tr>
    		<td>POST /emojis</td>
    		<td>Creates a new emoji</td>
  		</tr>
  		<tr>
    		<td>PUT /emojis/{id}</td>
    		<td>Updates an emoji</td>
  		</tr>
  		<tr>
    		<td>PATCH /emojis/{id}</td>
    		<td>Partially updates an emoji</td>
  		</tr>
  		<tr>
    		<td>DELETE /emojis/{id}</td>
    		<td>Deletes a single emoji</td>
  		</tr>
  		<tr>
    		<td>GET /register</td>
    		<td>Displays user registration form (For registration via browser only!)</td>
  		</tr>
  		<tr>
    		<td>POST /register</td>
    		<td>Creates a user account</td>
  		</tr>
  		<tr>
    		<td>PATCH /user/{username}</td>
    		<td>Changes password of a user</td>
  		</tr>
  		<tr>
    		<td>DELETE /user/{username}</td>
    		<td>Deletes a user account</td>
  		</tr>
  		<tr>
    		<td>GET /</td>
    		<td>Displays a Welcome page</td>
  		</tr>
		</table></div>";
    }

	/**
	 * Display user registration form
	 *
	 * @return string User registration form
	 */
    public static function form()
    {
        return "<div style='padding-left:450px;padding-top:200px'>" .
        "<form action='/register' method='post'>" .
        "Username: <input type='text' required autocomplete='off' name='username' placeholder='Enter a username' /><br><br>" .
        "Password: <input type='password' required autocomplete='off' name='password' placeholder='Enter a password' /><br><br>" .
        "Confirm Password: <input type='password' required autocomplete='off' name='password1' placeholder='Enter the password once more' /><br><br>" .
        "Purpose: <textarea name='purpose' required maxlength='50' rows='4' cols='50' placeholder='Why do you want to use our service?'></textarea><br><br>" .
        "<input type='submit' value='Register' />" .
        "</form>" .
        "</div>";
    }
}
