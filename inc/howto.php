<?php
/*
 * @Author: crimsonstrife
 * @Date: 2022-04-26 15:30:51
 * @Last Modified by: crimsonstrife
 * @Last Modified time: 2022-04-27 22:53:56
 *
 */
?>

<div class="howtobody">
    <nav id="howtosidebar">
        <header>CEO Juice API Plugin Documentation</header>
        <ul>
            <li>
                <a class="nav-link" href="#Intro">Introduction</a>
            </li>
            <li>
                <a class="nav-link" href="#Account">Setting Up Your Account</a>
            </li>
            <li>
                <a class="nav-link" href="#How-to">How To</a>
            </li>
            <li>
                <a class="nav-link" href="#Reference">Reference</a>
            </li>
        </ul>
    </nav>
    <main class="howtocontainer">
        <section class="main-sec" id="Intro">
            <header>
                <h1>Introduction</h1>
            </header>
            <article>
                <p>Keeping statistics and testimonials to support great customer feedback updated can be a challenge.
                    The CEO Juice API can make this easy by tracking the feedback you receive and providing the data in
                    a
                    usable format. Without an internal Web Developer however, you may find it difficult to implement
                    these features and an official solution does not currently exist. <br /> I developed this plugin
                    after
                    requests from Modern Impressions to implement these API calls into
                    their WordPress site. I added those to a theme, but by breaking it off into a plugin I can
                    distribute it and better the community. <br /> While I accept donations/tips <a
                        href="https://www.patrickbarnhardt.com/plugins/ceojuice">on my
                        website</a> this plugin is provided free to the community.</p>
                <h3>What is CEO Juice?</h3>
                <ul>
                    <li>CEO Juice is a service for copier dealers that use ECi's eAutomate software.</li>
                    <li>CEO Juice uses a.i. software to build and validate reports using eAutomate data.</li>
                    <li>The CEO Juice API is a RESTful API that can be accessed via JSON requests.</li>
                    <li>The CEO Juice API will show the last 12 months of NPS data.</li>
                </ul>
            </article>
        </section>
        <section class="main-sec" id="Account">
            <header>
                <h1>Setting up your CEO Juice account for the API</h1>
            </header>
            <p>You must subscribe to alert(s) ID125 and ID230 for this to work for you.</p>
            <h3>Setting Up Your Account</h3>
            <ol>
                <li>
                    <p>Visit the Subscriptions link once signed in on the CEO Juice website. Search by the ID number and
                        click the green [IDXXX] button to the left of the desired subscription.</p>
                    <p><img src="<?php echo CJ_PLUGIN_URL . "assets/img/Subscriptions.png" ?>"
                            style="border: 1px solid; border-color: #ececec; border-color: rgba(0, 0, 0, 0.07); height: auto; max-width: 100%; padding: 3px;"
                            alt="Subscriptions.png">
                    </p>
                </li>
                <li>
                    <p>Click on the [Subscribe] button, then don't forget to click the [Save] button in the upper right.
                    </p>
                    <p><img src="<?php echo CJ_PLUGIN_URL . "assets/img/Subscription Details.png" ?>"
                            style="border: 1px solid; border-color: #ececec; border-color: rgba(0, 0, 0, 0.07); height: auto; max-width: 100%; padding: 3px;"
                            alt="Subscriptions_Details.png">
                    </p>
                </li>
                <li>
                    <p>If you intend to use the Testimonials feature, you'll need to favorite some surveys, this can be
                        done from the Surveys Dashboard page.</p>
                    <p><img src="<?php echo CJ_PLUGIN_URL . "assets/img/Surveys.png" ?>"
                            style="border: 1px solid; border-color: #ececec; border-color: rgba(0, 0, 0, 0.07); height: auto; max-width: 100%; padding: 3px;"
                            alt="Surveys.png">
                    </p>
                </li>
                <li></li>
            </ol>
        </section>
        <section class="main-sec" id="How-to">
            <article>
                <header>
                    <h1>How To</h1>
                </header>
                <p>
                </p>
                <h3></h3>
                <p></p>
                <ul>
                    <li></li>
                    <li></li>
                    <li></li>
                </ul>
                <h4></h4>
                <p>
                </p>
            </article>
        </section>
        <section class="main-sec" id="Reference">
            <header>
                <h1>Reference</h1>
            </header>
            <p>
            </p>
        </section>
    </main>
</div>
<?php ?>
