# PyroStreams Page Field Type 2.0

This field type allows you to select a page from your PyroCMS page tree as a PyroStreams field.

## Changelog

**2.0 - April 18, 2013**

* Now compatible with PyroCMS 2.2.x
* Adding more available variables, including the anchor variable (see below)

**1.2 - January 17, 2011**

* [New] Added current variable that returns true/false whether the current page is the selected page.

**1.1.1 - December 15, 2011**

* [Bug] Fixed bug where when editing an entry with a page field, the page field would not show the selected page as selected

**1.1 - December 13, 2011**

* [Updated] Updated to be compatible with PyroCMS 2.0 and PyroStreams 2.1
* [New] Added drop down that displays page hierarchy.
* [New] Added a link to the PyroCMS page edit page when displaying page name on the back end.
* [Improvement] Field now obeys is_required setting for assignment.

## Installation

If it doesn't exist exists, create a _field\_types_ folder in either _addons/<site-ref> or _addons/shared\_addons_. Create a folder called "page" in your field\_types folder and add the file in this repo to that folder.

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
	<td>{{ field_slug:anchor }}</td>
		<td>Anchor with full URL and title used as the anchor text.</td>
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

<tr>
	<td>{{ field_slug:parent_id }}</td>
	<td>ID of the parent page</td>
</tr>

<tr>
	<td>{{ field_slug:entry_id }}</td>
	<td>ID of the stream entry that this page is linked to.</td>
</tr>

<tr>
	<td>{{ field_slug:type_id }}</td>
	<td>ID of the page type this page is linked to.</td>
</tr>

<tr>
	<td>{{ field_slug:meta_title }}</td>
	<td>Unparsed metatitle.</td>
</tr>

<tr>
	<td>{{ field_slug:meta_title }}</td>
	<td>Unparsed metatitle.</td>
</tr>

<tr>
	<td>{{ field_slug:meta_description }}</td>
	<td>Unparsed meta description.</td>
</tr>

<tr>
	<td>{{ field_slug:comments_enabled }}</td>
	<td>Are comments enabled? 1 or 0.</td>
</tr>

<tr>
	<td>{{ field_slug:status }}</td>
	<td>'live' or 'draf'.</td>
</tr>

<tr>
	<td>{{ field_slug:strict_uri }}</td>
	<td>Is this page set with a strict URI? 1 or 0.</td>
</tr>

<tr>
	<td>{{ field_slug:is_home }}</td>
	<td>Is this page the home page? 1 or 0.</td>
</tr>

<tr>
	<td>{{ field_slug:css }}</td>
	<td>The page CSS.</td>
</tr>

<tr>
	<td>{{ field_slug:js }}</td>
	<td>The page JS.</td>
</tr>

</table>