# PyroStreams Page Field Type v1.1.3

This field type allows you to select a page from your PyroCMS page tree as a PyroStreams field.

## Changelog

_1.1.2 - January 17, 2011_

* [New] Added current variable that returns true/false whether the current page is the selected page.

_1.1.1 - December 15, 2011_

* [Bug] Fixed bug where when editing an entry with a page field, the page field would not show the selected page as selected

_1.1 - December 13, 2011_

* [Updated] Updated to be compatible with PyroCMS 2.0 and PyroStreams 2.1
* [New] Added drop down that displays page hierarchy.
* [New] Added a link to the PyroCMS page edit page when displaying page name on the back end.
* [Improvement] Field now obeys is_required setting for assignment.

## Installation

If none exists, create a _field\_types_ folder in either _addons/<site-ref> or _addons/shared\_addons_. Create a folder called "page" in your field\_types folder and add the file in this repo to that folder.

## Usage

After being assigned to a stream, the following variables are available in your layouts:

<table>
<tr>
<th>Variable </th>
		<th>Notes </th>
	</tr>
<tr>
<td>{{ field_slug:link }}</td>
		<td>Full URL to the page</td>
	</tr>
<tr>
<td>{{ field_slug:slug }}</td>
		<td>Page URI slug</td>
	</tr>
<tr>
<td>{{ field_slug:title }}</td>
		<td>Page title</td>
	</tr>
<tr>
<td>{{ field_slug:id }}</td>
		<td>Page ID</td>
	</tr>
<tr>
<td>{{ field_slug:status }}</td>
		<td>Page status (draft or live)</td>
	</tr>
<tr>
<td>{{ field_slug:current }}</td>
		<td>Whether or not this is the current page. Returns true/false</td>
	</tr>
</table>
